<?php
declare(strict_types=1);

namespace Elephox\Http\Contract;

use ArrayAccess;
use Elephox\Collection\Contract\GenericKeyedEnumerable;
use Elephox\Http\ParameterSource;

/**
 * @extends ArrayAccess<non-empty-string, mixed>
 */
interface ParameterMap extends ArrayAccess
{
	public static function fromGlobals(?array $post = null, ?array $get = null, ?array $server = null, ?array $env = null): ParameterMap;

	public function get(string $key, ?ParameterSource $source = null): mixed;

	public function has(string $key, ?ParameterSource $source = null): bool;

	public function put(string $key, ParameterSource $source, mixed $value): void;

	public function remove(string $key, ?ParameterSource $source = null): void;

	/**
	 * @return GenericKeyedEnumerable<ParameterSource, mixed>
	 *
	 * @param string $key
	 */
	public function all(string $key): GenericKeyedEnumerable;

	/**
	 * @return GenericKeyedEnumerable<string, mixed>
	 *
	 * @param ?ParameterSource $source
	 */
	public function allFrom(?ParameterSource $source = null): GenericKeyedEnumerable;
}
