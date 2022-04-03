<?php
declare(strict_types=1);

namespace Elephox\Console;

use Elephox\Configuration\ConfigurationManager;
use Elephox\Configuration\Contract\ConfigurationRoot;
use Elephox\Console\Command\RawCommandInvocation;
use Elephox\Console\Command\CommandCollection;
use Elephox\Console\Contract\ConsoleEnvironment;
use Elephox\DI\Contract\ServiceCollection as ServiceCollectionContract;
use Elephox\DI\ServiceCollection;

class ConsoleApplication
{
	public function __construct(
		public readonly ServiceCollectionContract $services,
		public readonly ConsoleEnvironment $environment,
		public readonly ConfigurationRoot $configuration,
	)
	{
	}

	public static function createBuilder(): ConsoleApplicationBuilder
	{
		$configuration = new ConfigurationManager();
		$environment = new GlobalConsoleEnvironment();
		$services = new ServiceCollection();
		$commands = new CommandCollection($services->resolver());

		return new ConsoleApplicationBuilder(
			$configuration,
			$environment,
			$services,
			$commands,
		);
	}

	public function run(): void
	{
		$invocation = RawCommandInvocation::fromCommandLine();

		$this->handle($invocation);
	}

	public function handle(RawCommandInvocation $invocation): void
	{
		$compiled = $this->services
			->requireService(CommandCollection::class)
			->findCompiled($invocation);

		$compiled->handler->handle($invocation->build($compiled->template));
	}
}
