<?php

namespace Quazardous\ImagestackBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class CacheFactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        
        if (!$container->has('quazardous_imagestack.cache_provider')) {
            return;
        }
        
        $definition = $container->findDefinition(
            'quazardous_imagestack.cache_provider'
        );
        
        $taggedServices = $container->findTaggedServiceIds('quazardous_imagestack.cache_factory');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'registerCacheFactory',
                array(new Reference($id))
            );
        }
    }
}