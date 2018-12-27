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

    protected function setUp(): void
    {
        $this->page = new Page();
    }

    public function testToString(): void
    {
        $this->page->setTitle('foo');
        $this->assertEquals('foo', $this->page->__toString());
    }

    public function testGetId(): void
    {
        $this->assertNull($this->page->getId());
    }

    public function testGetTemplate(): void
    {
        $this->page->setTemplate('foo');
        $this->assertEquals('foo', $this->page->getTemplate());
    }

    public function testGetPath(): void
    {
        $this->page->setPath('foo');
        $this->assertEquals('foo', $this->page->getPath());
    }

    public function testGetTitle(): void
    {
        $this->page->setTitle('foo');
        $this->assertEquals('foo', $this->page->getTitle());
    }

    public function testGetContent(): void
    {
        $this->page->setContent('foo');
        $this->assertEquals('foo', $this->page->getContent());
    }
}
