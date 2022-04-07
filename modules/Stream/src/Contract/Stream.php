<?php
declare(strict_types=1);

namespace Elephox\Stream\Contract;

use Stringable;

interface Stream extends Stringable
{
	/**
	 * @return closed-resource|resource|null
	 */
	public function detach();

	public function close(): void;

	/**
	 * @return positive-int|null|0
	 */
	public function getSize(): ?int;

	/**
	 * @return positive-int|0
	 */
	public function tell(): int;

	public function eof(): bool;

	public function isSeekable(): bool;

	/**
	 * @param positive-int|0 $offset
	 * @param positive-int|0 $whence
	 */
	public function seek($offset, $whence = SEEK_SET): void;

	public function rewind(): void;

	public function isWriteable(): bool;

	/**
	 * @return positive-int|0
	 */
	public function write(string $string): int;

	public function isReadable(): bool;

	public function read(int $length): string;

	public function getContents(): string;

	public function getMetadata(?string $key = null): mixed;
}
