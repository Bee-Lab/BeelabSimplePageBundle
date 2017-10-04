<?php

namespace Beelab\SimplePageBundle\Validator\Constraints;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validate that a path is not used by any existing route.
 */
class NoExistingRouteValidator extends ConstraintValidator
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var bool
     */
    private $showRoute;

    /**
     * @param RouterInterface $router
     * @param bool            $showRoute
     */
    public function __construct(RouterInterface $router, bool $showRoute = true)
    {
        $this->router = $router;
        $this->showRoute = $showRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $routes = $this->router->getRouteCollection();
        /* @var \Symfony\Component\Routing\Route $route */
        foreach ($routes as $name => $route) {
            if ($route->getPath() === '/'.$value) {
                if ($this->showRoute) {
                    $this->context->addViolation($constraint->message, ['{{ route }}' => $name]);
                } else {
                    $this->context->addViolation($constraint->messageWithoutRoute);
                }
                break;
            }
        }
    }
}
