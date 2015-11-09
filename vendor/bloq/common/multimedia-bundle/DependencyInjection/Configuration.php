<?php

namespace Bloq\Common\MultimediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bloq_multimedia');

        $rootNode
            ->children()
                ->scalarNode('domain_path')->isRequired(true)->end()
                ->scalarNode('upload_dir')->isRequired(true)->end()
                ->arrayNode('images')
                    ->children()
                        ->scalarNode('root_dir_rel_path')->isRequired(true)->end()
                        ->scalarNode('root_dir_rel_url')->isRequired(true)->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
