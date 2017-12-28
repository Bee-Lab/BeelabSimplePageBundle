<?php

namespace Beelab\SimplePageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your configuration files.
 *
 * To learn more see {@link http://symfony.com/doc/current/bundles/extension.html}
 */
class Configuration implements ConfigurationInterface
{
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
