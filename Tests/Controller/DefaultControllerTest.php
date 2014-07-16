<?php

namespace Beelab\SimplePageBundle\Tests\Controller;

use Beelab\SimplePageBundle\Controller\DefaultController;
use PHPUnit_Framework_TestCase;

class DefaultControllerTest extends PHPUnit_Framework_TestCase
{
    protected $controller, $container, $formBuilder, $userManager;

    public function setUp()
    {
        $this->container = $this->getMockBuilder('Symfony\Component\DependencyInjection\Container')->disableOriginalConstructor()->getMock();
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
            ->expects($this->once())
            ->method('has')
            ->with('doctrine')
            ->will($this->returnValue(true))
        ;
        $this->container
            ->expects($this->once())
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
        $this->markTestIncomplete();
    }
}
