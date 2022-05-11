<?php
declare(strict_types=1);

namespace Elephox\Console\Command;

use Elephox\Collection\ArrayMap;
use LogicException;

/**
 * @extends ArrayMap<string, Option>
 */
class OptionList extends ArrayMap
{
	public static function create(CommandTemplate $template, CommandInvocationParametersMap $argumentsMap): self
	{
		$options = new self();

		foreach ($template->optionTemplates as $optionTemplate) {
			$matchedPair = $argumentsMap->firstPairOrDefault(null, static fn (bool|string $value, string|int $key) => $key === $optionTemplate->name || $key === $optionTemplate->short);
			if ($matchedPair === null) {
				if (!$optionTemplate->hasValue) {
					continue;
				}

				$option = Option::fromTemplate($optionTemplate, $optionTemplate->default);
			} else {
				$option = Option::fromTemplate($optionTemplate, $matchedPair->getValue());
			}

			$options->put($optionTemplate->name, $option);
			if ($optionTemplate->short !== null) {
				$options->put($optionTemplate->short, $option);
			}
		}

		return $options;
	}

	public function tryGet(string $name): ?Option
	{
		return $this->firstOrDefault(null, static fn(Option $o) => $o->name === $name || $o->short === $name);
	}

	public function get(mixed $key): Option
	{
		return $this->tryGet($key) ?? throw new OptionNotFoundException("Option '$key' not found.");
	}

	public function __get(string $name): Option
	{
		return $this->get($name);
	}

	public function __isset(string $name): bool
	{
		return $this->tryGet($name) !== null;
	}

	public function __set(string $name, mixed $value): void
	{
		throw new LogicException("Cannot set options.");
	}
}
