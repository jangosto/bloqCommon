<?php

namespace Bloq\Common\EntitiesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;  
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bloq_entities');

        $rootNode
            ->children()
                ->arrayNode('entities')
                    ->useAttributeAsKey('id')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('model_class')->isRequired(true)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
