<?php

namespace Beelab\SimplePageBundle\Controller;

use Beelab\SimplePageBundle\Util\BreadCrumbs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Show action
     *
     * You must define a final route in your configuration, pointing to this action
     */
    public function showAction($path = '')
    {
        $entity = $this->container->getParameter('beelab_simple_page.page_class');
        $resourcesPrefix = $this->container->getParameter('beelab_simple_page.resources_prefix');
        $page = $this->getDoctrine()->getRepository($entity)->findOneByPath($path);
        if (empty($page)) {
            throw $this->createNotFoundException(sprintf('Page not found for path "%s".', $path));
        }
        $breadCrumbs = BreadCrumbs::create($path);

        return $this->render($resourcesPrefix . $page->getTemplate() . '.html.twig', array(
            'page'        => $page,
            'breadCrumbs' => $breadCrumbs,
        ));
    }
}
