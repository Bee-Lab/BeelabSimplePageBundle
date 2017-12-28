<?php

namespace Beelab\SimplePageBundle\Controller;

use Beelab\SimplePageBundle\Util\BreadCrumbs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * Show action.
     *
     * You must define a final route in your configuration, pointing to this action
     */
    public function showAction(string $path = ''): Response
    {
        $entity = $this->getParameter('beelab_simple_page.page_class');
        $resourcesPrefix = $this->getParameter('beelab_simple_page.resources_prefix');
        $page = $this->getDoctrine()->getRepository($entity)->findOneByPath($path);
        if (empty($page)) {
            throw $this->createNotFoundException(sprintf('Page not found for path "/%s".', $path));
        }
        $breadCrumbs = BreadCrumbs::create($path);
        $template = $resourcesPrefix.str_replace(' ', '_', $page->getTemplate()).'.html.twig';

        return $this->render($template, ['page' => $page, 'breadCrumbs' => $breadCrumbs]);
    }
}
