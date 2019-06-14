<?php

namespace Beelab\SimplePageBundle\Tests\Controller;

use Beelab\SimplePageBundle\Controller\DefaultController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultControllerTest extends TestCase
{
    /**
     * @var DefaultController
     */
    protected $controller;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $this->controller = new DefaultController();
        $this->controller->setContainer($this->container);
    }

    public function testShowActionPageNotFound(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $registry = $this->createMock('Doctrine\Common\Persistence\ManagerRegistry');
        $repo = $this->getMockBuilder('Doctrine\ORM\EntityRepository')->disableOriginalConstructor()->getMock();
        $this->container
            ->expects($this->at(0))
            ->method('getParameter')
            ->with('beelab_simple_page.page_class')
            ->willReturn('foo')
        ;
        $this->container
            ->expects($this->at(1))
            ->method('getParameter')
            ->with('beelab_simple_page.resources_prefix')
            ->willReturn('bar')
        ;
        $this->container
            ->expects($this->any())
            ->method('has')
            ->willReturn(true)
        ;
        $this->container
            ->expects($this->any())
            ->method('get')
            ->with('doctrine')
            ->willReturn($registry)
        ;
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with('foo')
            ->willReturn($repo)
        ;

        $this->controller->showAction('baz');
    }

    public function testShowAction(): void
    {
        $page = $this->createMock('Beelab\SimplePageBundle\Entity\Page');
        $doctrine = $this->createMock('Doctrine\Common\Persistence\ManagerRegistry');
        $templating = $this->createMock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $response = $this->createMock('Symfony\Component\HttpFoundation\Response');

        $repo = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['findOneByPath'])
            ->getMock();
        $this->container
            ->expects($this->at(0))
            ->method('getParameter')
            ->with('beelab_simple_page.page_class')
            ->willReturn('foo')
        ;
        $this->container
            ->expects($this->at(1))
            ->method('getParameter')
            ->with('beelab_simple_page.resources_prefix')
            ->willReturn('bar')
        ;
        $this->container
            ->expects($this->any())
            ->method('has')
            ->willReturn(true)
        ;
        $this->container
            ->expects($this->any())
            ->method('get')
            ->with($this->callback(function ($arg) {
                return $arg;
            }))
            ->willReturnCallback(function ($arg) use ($doctrine, $templating) {
                return ${$arg};
            })
        ;
        $doctrine
            ->expects($this->once())
            ->method('getRepository')
            ->with('foo')
            ->willReturn($repo)
        ;
        $repo
            ->expects($this->once())
            ->method('findOneByPath')
            ->with('foo')
            ->willReturn($page)
        ;
        // we need to expect both "render" and "renderResponse" to support older Symfony versions
        $templating
            ->expects($this->any())
            ->method('renderResponse')
            ->willReturn($response)
        ;
        $templating
            ->expects($this->any())
            ->method('render')
            ->willReturn($response)
        ;

        $this->controller->showAction('foo');
    }
}
