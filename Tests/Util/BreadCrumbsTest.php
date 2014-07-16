<?php

namespace Beelab\MediaBundle\Tests\Util;

use Beelab\SimplePageBundle\Util\BreadCrumbs;
use PHPUnit_Framework_TestCase;

/**
 * @group unit
 */
class BreadCrumbsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerCreate
     */
    public function testCreate($path, $breadCrumbs)
    {
        $this->assertEquals($breadCrumbs, BreadCrumbs::create($path));
    }

    public function providerCreate()
    {
        return array(
            array('foo', array('foo' => 'foo')),
            array('foo/bar', array('foo' => 'foo', 'foo/bar' => 'bar')),
            array('foo/bar/baz', array('foo' => 'foo', 'foo/bar' => 'bar', 'foo/bar/baz' => 'baz')),
        );
    }
}
