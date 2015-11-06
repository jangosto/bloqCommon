<?php

namespace Bloq\Common\EditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;  
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bloq_editor');

        $rootNode
            ->children()
                ->arrayNode('editorial_contents')
                        ->useAttributeAsKey('id')
                    	->prototype('array')
                            ->children()
                                ->scalarNode('model_class')->isRequired(true)->end()
                                ->scalarNode('manager_class')->isRequired(true)->end()
                                ->scalarNode('form_type_class')->isRequired(true)->end()
                                ->scalarNode('form_type_name')->isRequired(true)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
