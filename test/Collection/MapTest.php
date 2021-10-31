<?php

namespace Philly\Base\Collection;

use InvalidArgumentException;
use Mockery as M;
use Philly\Base\Support\Contract\HashGenerator;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Philly\Base\Collection\Map
 * @covers \Philly\Base\Support\SplObjectIdHashGenerator
 */
class MapTest extends TestCase
{
    public function testPutAndGet(): void
    {
        /**
         * @var Map<string, mixed> $map
         * @noinspection PhpRedundantVariableDocTypeInspection
         */
        $map = new Map();

        $map->put('testKey', 'testValue');
        $map->put('anotherKey', 'anotherValue');

        self::assertEquals('testValue', $map->get('testKey'));
        self::assertEquals('anotherValue', $map->get('anotherKey'));
    }

    public function testInitialize(): void
    {
        $map = new Map(['test' => 'val', 123 => '134']);

        self::assertEquals('val', $map->get('test'));
    }

    public function testObjectKey(): void
    {
        /**
         * @var Map<stdClass, mixed> $map
         * @noinspection PhpRedundantVariableDocTypeInspection
         */
        $map = new Map();

        $key = new stdClass();
        $map->put($key, "test");

        self::assertEquals("test", $map->get($key));
    }

    public function testInvalidKey(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /**
         * @var Map<float, mixed> $map
         * @noinspection PhpRedundantVariableDocTypeInspection
         * @psalm-suppress InvalidTemplateParam
         */
        $map = new Map();

        $map->put(123.542, "test");
    }

    public function testGenerator(): void
    {
        $hashGeneratorMock = M::mock(HashGenerator::class);

        $obj = new stdClass();

        $hashGeneratorMock
            ->expects('generateHash')
            ->with($obj)
            ->twice()
            ->andReturn("testhash")
        ;

        $map = new Map(hashGenerator: $hashGeneratorMock);

        $map->put($obj, "test");

        self::assertEquals("test", $map->get($obj));
    }

    public function testFirst(): void
    {
        $map = new Map(['653', '123', '1543']);

        self::assertEquals("123", $map->first(fn(string $a) => $a[0] === '1'));
    }

    public function testWhere(): void
    {
        $map = new Map(['653', '123', '154']);
        $res = $map->where(fn(string $a) => str_ends_with($a, '3'));

        self::assertInstanceOf(Map::class, $res);
        self::assertEquals('653', $res->get(0));
    }
}
