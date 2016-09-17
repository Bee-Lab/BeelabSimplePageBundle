<?php

namespace Beelab\SimplePageBundle\Tests\Controller;

use Beelab\SimplePageBundle\Controller\DefaultController;
use PHPUnit_Framework_TestCase;

class DefaultControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DefaultController
     */
    protected $controller;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    protected function setUp()
    {
        $this->container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $this->controller = new DefaultController();
        $this->controller->setContainer($this->container);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testShowActionPageNotFound()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $repo = $this->getMockBuilder('Doctrine\ORM\EntityRepository')->disableOriginalConstructor()->getMock();
        $this->container
            ->expects($this->at(0))
            ->method('getParameter')
            ->with('beelab_simple_page.page_class')
            ->will($this->returnValue('foo'))
        ;
        $this->container
            ->expects($this->at(1))
            ->method('getParameter')
            ->with('beelab_simple_page.resources_prefix')
            ->will($this->returnValue('bar'))
        ;
        $this->container
            ->expects($this->any())
            ->method('has')
            ->will($this->returnValue(true))
        ;
        $this->container
            ->expects($this->any())
            ->method('get')
            ->with('doctrine')
            ->will($this->returnValue($registry))
        ;
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with('foo')
            ->will($this->returnValue($repo))
        ;

        $this->controller->showAction('baz');
    }

    public function testShowAction()
    {
        $page = $this->getMock('Beelab\SimplePageBundle\Entity\Page');
        $doctrine = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $templating = $this->getMock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $response = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $repo = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['findOneByPath'])
            ->getMock();
        $this->container
            ->expects($this->at(0))
            ->method('getParameter')
            ->with('beelab_simple_page.page_class')
            ->will($this->returnValue('foo'))
        ;
        $this->container
            ->expects($this->at(1))
            ->method('getParameter')
            ->with('beelab_simple_page.resources_prefix')
            ->will($this->returnValue('bar'))
        ;
        $this->container
            ->expects($this->any())
            ->method('has')
            ->will($this->returnValue(true))
        ;
        $this->container
            ->expects($this->any())
            ->method('get')
            ->with($this->callback(function ($arg) {
                return $arg;
            }))
            ->will($this->returnCallback(function ($arg) use ($doctrine, $templating) {
                return ${$arg};
            }))
        ;
        $doctrine
            ->expects($this->once())
            ->method('getRepository')
            ->with('foo')
            ->will($this->returnValue($repo))
        ;
        $repo
            ->expects($this->once())
            ->method('findOneByPath')
            ->with('foo')
            ->will($this->returnValue($page))
        ;
        $templating
            ->expects($this->once())
            ->method('renderResponse')
            ->will($this->returnValue($response))
        ;

        $this->controller->showAction('foo');
    }
}
