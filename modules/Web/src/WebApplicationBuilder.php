<?php
declare(strict_types=1);

namespace Elephox\Web;

use Doctrine\ORM\Configuration as DoctrineConfiguration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup as DoctrineSetup;
use Elephox\Configuration\ConfigurationManager;
use Elephox\Configuration\Contract\Configuration;
use Elephox\Configuration\Contract\ConfigurationBuilder as ConfigurationBuilderContract;
use Elephox\Configuration\Contract\ConfigurationManager as ConfigurationManagerContract;
use Elephox\Configuration\Contract\ConfigurationRoot;
use Elephox\Configuration\Contract\Environment;
use Elephox\Configuration\LoadsDefaultConfiguration;
use Elephox\DI\Contract\ServiceCollection as ServiceCollectionContract;
use Elephox\DI\ServiceCollection;
use Elephox\Http\Contract\Request as RequestContract;
use Elephox\Http\Contract\ResponseBuilder;
use Elephox\Http\Response;
use Elephox\Http\ResponseCode;
use Elephox\Logging\Contract\Sink;
use Elephox\Logging\SingleSinkLogger;
use Elephox\Logging\Vendors\Logtail\LogtailClient;
use Elephox\Logging\Vendors\Logtail\LogtailConfiguration;
use Elephox\Logging\Vendors\Logtail\LogtailSink;
use Elephox\Support\Contract\ExceptionHandler;
use Elephox\Web\Contract\RequestPipelineEndpoint;
use Elephox\Web\Contract\WebEnvironment;
use Elephox\Web\Middleware\DefaultExceptionHandler;
use Elephox\Web\Middleware\LoggingMiddleware;
use Elephox\Web\Middleware\ServerTimingHeaderMiddleware;
use Elephox\Web\Middleware\WhoopsExceptionHandler;
use Elephox\Web\Routing\RequestRouter;
use Psr\Log\LoggerInterface;
use Whoops\Run as WhoopsRun;
use Whoops\RunInterface as WhoopsRunInterface;

/**
 * @psalm-consistent-constructor
 */
class WebApplicationBuilder
{
	use LoadsDefaultConfiguration;

	public static function create(
		?ServiceCollectionContract $services = null,
		?ConfigurationManagerContract $configuration = null,
		?WebEnvironment $environment = null,
		?RequestPipelineBuilder $pipeline = null,
	): static {
		$configuration ??= new ConfigurationManager();
		$environment ??= new GlobalWebEnvironment();
		$services ??= new ServiceCollection();
		$pipeline ??= new RequestPipelineBuilder(new class implements RequestPipelineEndpoint {
			public function handle(RequestContract $request): ResponseBuilder
			{
				return Response::build()->responseCode(ResponseCode::BadRequest);
			}
		});

		$services->addSingleton(Environment::class, implementation: $environment);
		$services->addSingleton(WebEnvironment::class, implementation: $environment);

		$services->addSingleton(Configuration::class, implementation: $configuration);

		$services->addSingleton(ExceptionHandler::class, DefaultExceptionHandler::class);

		return new static(
			$configuration,
			$environment,
			$services,
			$pipeline,
		);
	}

	public function __construct(
		public readonly ConfigurationManagerContract $configuration,
		public readonly WebEnvironment $environment,
		public readonly ServiceCollectionContract $services,
		public readonly RequestPipelineBuilder $pipeline,
	) {
		// Load .env, .env.local
		$this->loadDotEnvFile();

		// Load config.json, config.local.json
		$this->loadConfigFile();

		// Load .env.{$ENVIRONMENT}, .env.{$ENVIRONMENT}.local
		$this->loadEnvironmentDotEnvFile();

		// Load config.{$ENVIRONMENT}.json, config.{$ENVIRONMENT}.local.json
		$this->loadEnvironmentConfigFile();

		$this->addDefaultMiddleware();
	}

	protected function getEnvironment(): Environment
	{
		return $this->environment;
	}

	protected function getConfigurationBuilder(): ConfigurationBuilderContract
	{
		return $this->configuration;
	}

	protected function addDefaultMiddleware(): void
	{
		$this->pipeline->push(new ServerTimingHeaderMiddleware('pipeline'));
	}

	public function build(): WebApplication
	{
		$configuration = $this->configuration->build();
		$this->services->addSingleton(Configuration::class, implementation: $configuration, replace: true);

		$builtPipeline = $this->pipeline->build();
		$this->services->addSingleton(RequestPipeline::class, implementation: $builtPipeline);

		return new WebApplication(
			$this->services,
			$configuration,
			$this->environment,
			$builtPipeline,
		);
	}

	/**
	 * @param null|callable(WhoopsRunInterface): void $configurator
	 */
	public function addWhoops(?callable $configurator = null): void
	{
		$this->services->addSingleton(WhoopsRunInterface::class, WhoopsRun::class);

		if ($configurator) {
			$configurator($this->services->requireService(WhoopsRunInterface::class));
		}

		$whoopsExceptionHandler = new WhoopsExceptionHandler(fn () => $this->services->requireService(WhoopsRunInterface::class));

		$this->pipeline->push($whoopsExceptionHandler);

		$this->services->addSingleton(ExceptionHandler::class, implementation: $whoopsExceptionHandler, replace: true);
	}

	/**
	 * @param null|callable(mixed): \Doctrine\ORM\Configuration $setup
	 */
	public function addDoctrine(?callable $setup = null): void
	{
		$this->services->addSingleton(
			EntityManagerInterface::class,
			EntityManager::class,
			implementationFactory: function (ConfigurationRoot $configuration) use ($setup): EntityManagerInterface {
				$setup ??= static function (ConfigurationRoot $conf, WebEnvironment $env): DoctrineConfiguration {
					/** @var string|null $setupDriver */
					$setupDriver = $conf['doctrine:metadata:driver'];
					if (!is_string($setupDriver)) {
						throw new ConfigurationException('Doctrine configuration error: "doctrine:metadata:driver" must be a string.');
					}

					$setupMethod = match ($setupDriver) {
						'annotation' => 'createAnnotationMetadataConfiguration',
						'yaml' => 'createYAMLMetadataConfiguration',
						'xml' => 'createXMLMetadataConfiguration',
						default => throw new ConfigurationException('Unsupported doctrine metadata driver: ' . $setupDriver),
					};

					/** @var DoctrineConfiguration */
					return DoctrineSetup::{$setupMethod}(
						$conf['doctrine:metadata:paths'],
						$conf['doctrine:dev'] ?? $env->isDevelopment(),
					);
				};

				/** @psalm-suppress ArgumentTypeCoercion */
				$setupConfig = $this->services->resolver()->callback($setup);

				/** @var array<string, mixed>|null $connection */
				$connection = $configuration['doctrine:connection'];
				if (!is_array($connection)) {
					throw new ConfigurationException('No doctrine connection specified at "doctrine:connection"');
				}

				/** @var EntityManager */
				return EntityManager::create($connection, $setupConfig);
			},
		);
	}

	public function addLogtail(): void
	{
		$this->services->addSingleton(LogtailConfiguration::class, implementationFactory: static function (Configuration $config) {
			/** @var scalar|null $token */
			$token = $config['logtail:token'] ?? null;
			if (!is_string($token)) {
				throw new ConfigurationException('Logtail configuration error: "logtail:token" must be a string.');
			}

			$endpoint = $config['logtail:endpoint'] ?? LogtailConfiguration::DEFAULT_ENDPOINT;
			if (!is_string($endpoint)) {
				throw new ConfigurationException('Logtail configuration error: "logtail:endpoint" must be a string.');
			}

			return new LogtailConfiguration($token, $endpoint);
		});
		$this->services->addSingleton(LogtailClient::class);
		$this->services->addSingleton(Sink::class, LogtailSink::class, replace: true);
		$this->services->addSingleton(LoggerInterface::class, SingleSinkLogger::class, replace: true);

		$this->addRequestLogging();
	}

	public function addRequestLogging(): void
	{
		if ($this->services->has(LoggingMiddleware::class)) {
			$middleware = $this->services->requireService(LoggingMiddleware::class);
		} else {
			$middleware = $this->services->resolver()->instantiate(LoggingMiddleware::class);
		}

		$this->pipeline->push($middleware);
	}

	public function setRequestRouterEndpoint(?RequestRouter $router = null): RequestRouter
	{
		$router ??= new RequestRouter($this->services);
		$this->services->addSingleton(RequestRouter::class, implementation: $router, replace: true);
		$this->pipeline->endpoint($router);

		return $router;
	}

	/**
	 * @template T of object
	 *
	 * @param class-string<T>|string $name
	 *
	 * @return T
	 */
	public function service(string $name): object
	{
		/** @var T */
		return $this->services->require($name);
	}
}
