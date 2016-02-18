<?php

namespace Beelab\SimplePageBundle\Tests\Validator\Constraints;

use Beelab\SimplePageBundle\Validator\Constraints\NoExistingRoute;
use Beelab\SimplePageBundle\Validator\Constraints\NoExistingRouteValidator;
use Symfony\Component\Routing\Route;

class NoExistingRouteValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $router;
    protected $context;

    protected function setUp()
    {
        $this->router = $this->getMock('Symfony\Component\Routing\RouterInterface');
        $this->context = $this->getMock('Symfony\Component\Validator\Context\ExecutionContextInterface');
    }

    public function testInvalid()
    {
        $validator = new NoExistingRouteValidator($this->router);
        $validator->initialize($this->context);
        $routes = array('foo_bar' => new Route('/foobar'));
        $constraint = new NoExistingRoute();

        $this->router->expects($this->once())->method('getRouteCollection')->will($this->returnValue($routes));
        $this->context->expects($this->atLeastOnce())->method('addViolation');

        $validator->validate('foobar', $constraint);
    }

    public function testInvalidWithoutRoute()
    {
        $validator = new NoExistingRouteValidator($this->router, false);
        $validator->initialize($this->context);
        $routes = array('bar_foo' => new Route('/barfoo'));
        $constraint = new NoExistingRoute();

        $this->router->expects($this->once())->method('getRouteCollection')->will($this->returnValue($routes));
        $this->context->expects($this->atLeastOnce())->method('addViolation');

        $validator->validate('barfoo', $constraint);
    }

    public function testValid()
    {
        $validator = new NoExistingRouteValidator($this->router, false);
        $validator->initialize($this->context);
        $routes = array('foo_baz' => new Route('/foobaz'));
        $constraint = new NoExistingRoute();

        $this->router->expects($this->once())->method('getRouteCollection')->will($this->returnValue($routes));
        $this->context->expects($this->never())->method('addViolation');

        $validator->validate('bazbaz', $constraint);
    }
}
