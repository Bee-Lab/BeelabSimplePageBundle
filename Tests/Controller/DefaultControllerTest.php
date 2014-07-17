<?php

namespace Beelab\SimplePageBundle\Tests\Controller;

use Beelab\SimplePageBundle\Controller\DefaultController;
use PHPUnit_Framework_TestCase;

class DefaultControllerTest extends PHPUnit_Framework_TestCase
{
    protected $controller;
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
        $reg = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
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
            ->method('get')
            ->with('doctrine')
            ->will($this->returnValue($reg))
        ;
        $reg
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
        $reg = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $tpl = $this->getMock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $repo = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(array('findOneByPath'))
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
            ->expects($this->at(2))
            ->method('get')
            ->with('doctrine')
            ->will($this->returnValue($reg))
        ;
        $this->container
            ->expects($this->at(3))
            ->method('get')
            ->with('templating')
            ->will($this->returnValue($tpl))
        ;
        $reg
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
        $this->controller->showAction('foo');
    }
}
