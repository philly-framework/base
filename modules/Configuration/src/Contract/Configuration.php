<?php
declare(strict_types=1);

namespace Elephox\Configuration\Contract;

use ArrayAccess;
use Elephox\Collection\Contract\GenericEnumerable;
use Elephox\OOR\Str;

/**
 * @extends ArrayAccess<string, array|string|int|float|bool|null>
 */
interface Configuration extends ArrayAccess
{
	/**
	 * @return GenericEnumerable<string>
	 *
	 * @param null|string|Str $path
	 */
	public function getChildKeys(string|Str|null $path = null): GenericEnumerable;

	/**
	 * @return GenericEnumerable<ConfigurationSection>
	 *
	 * @param null|string|Str $path
	 */
	public function getChildren(string|Str|null $path = null): GenericEnumerable;

	public function hasSection(string|Str $key): bool;

	public function getSection(string|Str $key): ConfigurationSection;

	public function offsetGet(mixed $offset): array|string|int|float|bool|null;
}
