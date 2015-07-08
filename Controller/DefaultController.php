<?php

namespace Beelab\SimplePageBundle\Controller;

use Beelab\SimplePageBundle\Util\BreadCrumbs;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends ContainerAware
{
    /**
     * Show action.
     *
     * You must define a final route in your configuration, pointing to this action
     */
    public function showAction($path = '')
    {
        $entity = $this->container->getParameter('beelab_simple_page.page_class');
        $resourcesPrefix = $this->container->getParameter('beelab_simple_page.resources_prefix');
        $page = $this->container->get('doctrine')->getRepository($entity)->findOneByPath($path);
        if (empty($page)) {
            throw new NotFoundHttpException(sprintf('Page not found for path "/%s".', $path));
        }
        $breadCrumbs = BreadCrumbs::create($path);
        $template = $resourcesPrefix.str_replace(' ', '_', $page->getTemplate()).'.html.twig';

        return $this->container->get('templating')->renderResponse($template, array(
            'page'        => $page,
            'breadCrumbs' => $breadCrumbs,
        ));
    }
}
