<?php

namespace Beelab\SimplePageBundle\Tests\Util;

use Beelab\SimplePageBundle\Util\BreadCrumbs;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
final class BreadCrumbsTest extends TestCase
{
    /**
     * @dataProvider providerCreate
     */
    public function testCreate(string $path, array $breadCrumbs): void
    {
        $this->assertEquals($breadCrumbs, BreadCrumbs::create($path));
    }

    public function providerCreate(): array
    {
        return [
            ['foo', ['foo' => 'foo']],
            ['foo/bar', ['foo' => 'foo', 'foo/bar' => 'bar']],
            ['foo/bar/baz', ['foo' => 'foo', 'foo/bar' => 'bar', 'foo/bar/baz' => 'baz']],
        ];
    }
}
