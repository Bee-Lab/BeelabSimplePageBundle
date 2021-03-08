<?php

namespace Beelab\SimplePageBundle\Controller;

use Beelab\SimplePageBundle\Util\BreadCrumbs;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class DefaultController
{
    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var string
     */
    protected $prefix;

    public function __construct(ManagerRegistry $doctrine, Environment $twig, string $entity, string $prefix)
    {
        $this->doctrine = $doctrine;
        $this->twig = $twig;
        $this->entity = $entity;
        $this->prefix = $prefix;
    }

    /**
     * You must define a final route in your configuration, pointing to this action.
     */
    public function showAction(string $path = ''): Response
    {
        $page = $this->doctrine->getRepository($this->entity)->findOneByPath($path);
        if (empty($page)) {
            throw new NotFoundHttpException(\sprintf('Page not found for path "/%s".', $path));
        }
        $breadCrumbs = BreadCrumbs::create($path);
        $template = $this->prefix.\str_replace(' ', '_', $page->getTemplate()).'.html.twig';

        return new Response($this->twig->render($template, ['page' => $page, 'breadCrumbs' => $breadCrumbs]));
    }
}
