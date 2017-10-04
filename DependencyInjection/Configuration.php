<?php

namespace Beelab\SimplePageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('beelab_simple_page');
        $rootNode
            ->children()
                ->scalarNode('page_class')
                    ->isRequired()
                ->end()
                ->scalarNode('resources_prefix')
                    ->cannotBeEmpty()
                    ->defaultValue('BeelabSimplePageBundle:Default:')
                ->end()
                ->booleanNode('show_route')
                    ->defaultValue(true)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
