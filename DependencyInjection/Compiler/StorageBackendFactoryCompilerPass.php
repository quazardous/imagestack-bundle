<?php

namespace Quazardous\ImagestackBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class StorageBackendFactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        
        if (!$container->has('quazardous_imagestack.storage_backend_provider')) {
            return;
        }
        
        $definition = $container->findDefinition(
            'quazardous_imagestack.storage_backend_provider'
        );
        
        $taggedServices = $container->findTaggedServiceIds('quazardous_imagestack.storage_backend_factory');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'registerStorageBackendFactory',
                array(new Reference($id))
            );
        }
    }
}