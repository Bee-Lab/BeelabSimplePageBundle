<?php

namespace Beelab\SimplePageBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/bundles/extension.html}
 */
class BeelabSimplePageExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('beelab_simple_page.page_class', $config['page_class']);
        $container->setParameter('beelab_simple_page.resources_prefix', $config['resources_prefix']);
        $container->setParameter('beelab_simple_page.show_route', $config['show_route']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
