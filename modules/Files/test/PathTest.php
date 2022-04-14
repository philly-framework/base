<?php
declare(strict_types=1);

namespace Elephox\Files;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Elephox\Files\Path
 *
 * @internal
 */
class PathTest extends TestCase
{
	public function joinDataProvider(): iterable
	{
		yield [['/foo', 'bar', 'baz'], '/foo' . DIRECTORY_SEPARATOR . 'bar' . DIRECTORY_SEPARATOR . 'baz'];
		yield [['foo'], 'foo'];
		yield [['C:\\foo\\bar', 'test/var/x', 'deep/', 'folder'], 'C:\\foo\\bar' . DIRECTORY_SEPARATOR . 'test/var/x' . DIRECTORY_SEPARATOR . 'deep' . DIRECTORY_SEPARATOR . 'folder'];
	}

	/**
	 * @dataProvider joinDataProvider
	 *
	 * @param array $parts
	 * @param string $targetPath
	 */
	public function testJoin(array $parts, string $targetPath): void
	{
		$path = Path::join(...$parts);
		static::assertEquals($path, $targetPath);
	}

	public function rootDataProvider(): iterable
	{
		yield ['/long/path/to/test', false];
		yield ['/', true];
		yield ['C:\\Windows\\System32', false];
		yield ['C:\\', true];
	}

	/**
	 * @dataProvider rootDataProvider
	 *
	 * @param string $path
	 * @param bool $isRoot
	 */
	public function testIsRoot(string $path, bool $isRoot): void
	{
		static::assertEquals($isRoot, Path::isRoot($path));
	}

	public function relativeToProvider(): iterable
	{
		yield ['/var/www/test', '/var/tmp/db', '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'db'];
		yield ['C:\\data', 'C:\\data\\test\\more', 'test' . DIRECTORY_SEPARATOR . 'more'];
		yield ['C:\\data\\test\\more', 'C:\\data', '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR];
	}

	/**
	 * @dataProvider relativeToProvider
	 *
	 * @param string $pathA
	 * @param string $pathB
	 * @param string $result
	 */
	public function testRelativeTo(string $pathA, string $pathB, string $result): void
	{
		static::assertEquals($result, Path::relativeTo($pathA, $pathB));
	}
}
