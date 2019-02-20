<?php

namespace Quazardous\ImagestackBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('quazardous_imagestack');
        
//         $treeBuilder->getRootNode()
//             ->children()
//                 ->arrayNode('test')
//                     ->children()
//                         ->scalarNode('test')->end()
//                     ->end()
//                 ->end() // twitter
//         ->end();
        
        return $treeBuilder;
    }
}