<?php
declare(strict_types=1);

namespace Elephox\Files;

use DateTime;
use Elephox\Collection\ArrayList;
use JetBrains\PhpStorm\Pure;
use OutOfRangeException;

class Directory implements Contract\Directory
{
	#[Pure] public function __construct(
		private string $path,
	)
	{
	}

	public function getFiles(): ArrayList
	{
		/** @var ArrayList<Contract\File> */
		return $this->getChildren()->where(function (Contract\FilesystemNode $node) {
			return $node instanceof Contract\File;
		});
	}

	public function getDirectories(): ArrayList
	{
		/** @var ArrayList<Contract\Directory> */
		return $this->getChildren()->where(function (Contract\FilesystemNode $node) {
			return $node instanceof Contract\Directory;
		});
	}

	public function getChildren(): ArrayList
	{
		/** @var string[] $nodes */
		$nodes = scandir($this->path);

		/** @var ArrayList<string> $nodesArray */
		$nodesArray = ArrayList::fromArray($nodes);

		/** @var ArrayList<Contract\FilesystemNode> */
		return $nodesArray->map(function (string $name): Contract\FilesystemNode {
			$path = Path::join($this->path, $name);
			if (is_dir($path)) {
				return new Directory($path);
			}

			return new File($path);
		});
	}

	#[Pure] public function isRoot(): bool
	{
		return dirname($this->path) === trim($this->path, DIRECTORY_SEPARATOR);
	}

	public function isEmpty(): bool
	{
		return $this->getChildren()->isEmpty();
	}

	#[Pure] public function getPath(): string
	{
		return $this->path;
	}

	#[Pure] public function getName(): string
	{
		return basename($this->path);
	}

	public function getParent(int $levels = 1): Contract\Directory
	{
		if ($levels < 1) {
			throw new OutOfRangeException('Levels must be greater than 0');
		}

		return new Directory(dirname($this->path, $levels));
	}

	/**
	 * @throws \Exception
	 */
	public function getModifiedTime(): DateTime
	{
		return new DateTime('@' . filemtime($this->path));
	}
}
