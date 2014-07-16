<?php

namespace Beelab\SimplePageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
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
            ->end()
        ;

        return $treeBuilder;
    }
}
