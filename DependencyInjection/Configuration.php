<?php

namespace Tacticmedia\ImgixBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('tacticmedia_imgix');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('default_source')
                    ->defaultValue('default')
                    ->end()
                ->booleanNode('enabled')
                    ->defaultFalse()
                    ->end()
                ->append($this->getSourcesNode())
            ->end()
        ;

        return $treeBuilder;
    }

    private function getSourcesNode()
    {
        $treeBuilder = new TreeBuilder('sources');
        $node = $treeBuilder->getRootNode();

        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->arrayNode('domains')
                        ->isRequired()
                        ->requiresAtLeastOneElement()
                        ->prototype('scalar')
                        ->end()
                    ->end()
                    ->scalarNode('sign_key')
                        ->defaultValue('')
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
