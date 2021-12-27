<?php
declare(strict_types=1);

namespace Elephox\Collection\Contract;

use JetBrains\PhpStorm\Pure;

/**
 * @template T
 *
 * @extends ReadonlyList<T>
 */
interface GenericList extends ReadonlyList, Stackable
{
	/**
	 * @param T $value
	 */
	public function set(int $index, mixed $value): void;

	/**
	 * @param T $value
	 */
	public function add(mixed $value): void;

	/**
	 * @param int $index
	 *
	 * @return bool
	 */
	public function removeAt(int $index): bool;

	/**
	 * @param callable(T, int): bool $predicate
	 *
	 * @return bool
	 */
	public function remove(callable $predicate): bool;

	/**
	 * @param callable(T, T): int $callback
	 *
	 * @return GenericList<T>
	 */
	public function orderBy(callable $callback): GenericList;

	/**
	 * @return ReadonlyList<T>
	 */
	#[Pure] public function asReadonly(): ReadonlyList;
}
