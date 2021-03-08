<?php

namespace Beelab\SimplePageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('beelab_simple_page');
        $rootNode = $treeBuilder->getRootNode();
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
