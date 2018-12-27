<?php

namespace Beelab\SimplePageBundle\Tests\Validator\Constraints;

use Beelab\SimplePageBundle\Validator\Constraints\NoExistingRoute;
use Beelab\SimplePageBundle\Validator\Constraints\NoExistingRouteValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Route;

class NoExistingRouteValidatorTest extends TestCase
{
    protected $router;
    protected $context;

    protected function setUp(): void
    {
        $this->router = $this->createMock('Symfony\Component\Routing\RouterInterface');
        $this->context = $this->createMock('Symfony\Component\Validator\Context\ExecutionContextInterface');
    }

    public function testInvalid(): void
    {
        $validator = new NoExistingRouteValidator($this->router);
        $validator->initialize($this->context);
        $routes = ['foo_bar' => new Route('/foobar')];
        $constraint = new NoExistingRoute();

        $this->router->expects($this->once())->method('getRouteCollection')->will($this->returnValue($routes));
        $this->context->expects($this->atLeastOnce())->method('addViolation');

        $validator->validate('foobar', $constraint);
    }

    public function testInvalidWithoutRoute(): void
    {
        $validator = new NoExistingRouteValidator($this->router, false);
        $validator->initialize($this->context);
        $routes = ['bar_foo' => new Route('/barfoo')];
        $constraint = new NoExistingRoute();

        $this->router->expects($this->once())->method('getRouteCollection')->will($this->returnValue($routes));
        $this->context->expects($this->atLeastOnce())->method('addViolation');

        $validator->validate('barfoo', $constraint);
    }

    public function testValid(): void
    {
        $validator = new NoExistingRouteValidator($this->router, false);
        $validator->initialize($this->context);
        $routes = ['foo_baz' => new Route('/foobaz')];
        $constraint = new NoExistingRoute();

        $this->router->expects($this->once())->method('getRouteCollection')->will($this->returnValue($routes));
        $this->context->expects($this->never())->method('addViolation');

        $validator->validate('bazbaz', $constraint);
    }
}
