<?php
declare(strict_types=1);

namespace Elephox\Files;

use DateTime;
use Elephox\Files\Contract\FilesystemNode;
use Elephox\Support\Contract\MimeType;
use Exception;
use InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use RuntimeException;
use ValueError;

class File implements Contract\File
{
	#[Pure]
	public function __construct(
		private string    $path,
		private ?MimeType $mimeType = null,
	) {
	}

	#[Pure]
	public function getPath(): string
	{
		return $this->path;
	}

	#[Pure]
	public function getName(): string
	{
		return basename($this->path);
	}

	#[Pure]
	public function getExtension(): string
	{
		return pathinfo($this->path, PATHINFO_EXTENSION);
	}

	public function getSize(): int
	{
		if (!$this->exists()) {
			throw new FileNotFoundException($this->path);
		}

		$size = filesize($this->path);
		if ($size === false) {
			throw new RuntimeException("Unable to get the size of file ($this->path)");
		}

		return $size;
	}

	#[Pure]
	public function getMimeType(): ?MimeType
	{
		return $this->mimeType;
	}

	public function getModifiedTime(): DateTime
	{
		if (!$this->exists()) {
			throw new FileNotFoundException($this->path);
		}

		$timestamp = filemtime($this->path);
		if ($timestamp === false) {
			throw new RuntimeException("Failed to get modified time of file ($this->path)");
		}

		try {
			return new DateTime('@' . $timestamp);
		} catch (Exception $e) {
			throw new RuntimeException("Could not parse timestamp", previous: $e);
		}
	}

	public function getHash(): string
	{
		if (!$this->exists()) {
			throw new FileNotFoundException($this->path);
		}

		$hash = md5_file($this->path);
		if ($hash === false) {
			throw new RuntimeException("Could not hash file");
		}

		return $hash;
	}

	public function getParent(int $levels = 1): Directory
	{
		try {
			return new Directory(dirname($this->path, $levels));
		} catch (ValueError $error) {
			throw new InvalidParentLevelException($levels, previous: $error);
		}
	}

	#[Pure]
	public function isReadable(): bool
	{
		/** @psalm-suppress ImpureFunctionCall */
		return is_readable($this->path);
	}

	#[Pure]
	public function isWritable(): bool
	{
		return is_writable($this->path);
	}

	#[Pure]
	public function isExecutable(): bool
	{
		return is_executable($this->path);
	}

	public function exists(): bool
	{
		return file_exists($this->path);
	}

	public function copyTo(FilesystemNode $node, bool $overwrite = true): void
	{
		if (!$this->exists()) {
			throw new FileNotFoundException($this->path);
		}

		$destination = $this->getDestination($node, $overwrite);

		$success = copy($this->path, $destination->getPath());

		if (!$success) {
			throw new FileCopyException($this->path, $destination->getPath());
		}
	}

	public function delete(): void
	{
		if (!$this->exists()) {
			throw new FileNotFoundException($this->path);
		}

		if (!unlink($this->path)) {
			throw new FileDeleteException($this->path);
		}
	}

	public function moveTo(FilesystemNode $node, bool $overwrite = true): void
	{
		if (!$this->exists()) {
			throw new FileNotFoundException($this->path);
		}

		$destination = $this->getDestination($node, $overwrite);

		if (is_uploaded_file($this->path)) {
			$success = move_uploaded_file($this->path, $destination->getPath());
		} else {
			$success = rename($this->path, $destination->getPath());
		}

		if (!$success) {
			throw new FileMoveException($this->path, $destination->getPath());
		}
	}

	private function getDestination(FilesystemNode $node, bool $overwrite): Contract\File
	{
		if ($node instanceof Contract\Directory) {
			$destination = new self(Path::join($node->getPath(), $this->getName()));
		} else if ($node instanceof Contract\File) {
			$destination = $node;
		} else {
			throw new InvalidArgumentException("Given filesystem node is not a file or directory");
		}

		if (!$overwrite && $destination->exists()) {
			throw new FileAlreadyExistsException($destination->getPath());
		}

		return $destination;
	}
}
