<?php

namespace Beelab\SimplePageBundle\Tests\Validator\Constraints;

use Beelab\SimplePageBundle\Validator\Constraints\NoExistingRoute;

class NoExistingRouteTest extends \PHPUnit_Framework_TestCase
{
    public function testValidatedBy()
    {
        $constraint = new NoExistingRoute();

        $this->assertEquals('no_existing_route', $constraint->validatedBy());
    }
}
