<?php

namespace Beelab\SimplePageBundle\Tests\Validator\Constraints;

use Beelab\SimplePageBundle\Validator\Constraints\NoExistingRoute;
use PHPUnit_Framework_TestCase as TestCase;

class NoExistingRouteTest extends TestCase
{
    public function testValidatedBy()
    {
        $constraint = new NoExistingRoute();

        $this->assertEquals('no_existing_route', $constraint->validatedBy());
    }
}
