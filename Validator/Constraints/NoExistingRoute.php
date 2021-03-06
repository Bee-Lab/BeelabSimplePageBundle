<?php

namespace Beelab\SimplePageBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoExistingRoute extends Constraint
{
    public $message = 'This path match existing route ({{ route }}).';
    public $messageWithoutRoute = 'This path match existing route.';

    public function validatedBy(): string
    {
        return 'no_existing_route';
    }
}
