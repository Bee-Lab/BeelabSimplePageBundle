<?php

namespace Beelab\SimplePageBundle\Tests\Validator\Constraints;

use Beelab\SimplePageBundle\Validator\Constraints\NoExistingRoute;
use PHPUnit\Framework\TestCase;

class NoExistingRouteTest extends TestCase
{
    public function testValidatedBy(): void
    {
        $constraint = new NoExistingRoute();

        $this->assertEquals('no_existing_route', $constraint->validatedBy());
    }
}
