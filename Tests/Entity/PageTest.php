<?php

namespace Beelab\MediaBundle\Tests\Entity;

use Beelab\SimplePageBundle\Entity\Page;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class PageTest extends TestCase
{
    protected $page;

    protected function setUp()
    {
        $this->page = new Page();
    }

    public function testToString()
    {
        $this->page->setTitle('foo');
        $this->assertEquals('foo', $this->page->__toString());
    }

    public function testGetId()
    {
        $this->assertNull($this->page->getId());
    }

    public function testGetTemplate()
    {
        $this->page->setTemplate('foo');
        $this->assertEquals('foo', $this->page->getTemplate());
    }

    public function testGetPath()
    {
        $this->page->setPath('foo');
        $this->assertEquals('foo', $this->page->getPath());
    }

    public function testGetTitle()
    {
        $this->page->setTitle('foo');
        $this->assertEquals('foo', $this->page->getTitle());
    }

    public function testGetContent()
    {
        $this->page->setContent('foo');
        $this->assertEquals('foo', $this->page->getContent());
    }
}
