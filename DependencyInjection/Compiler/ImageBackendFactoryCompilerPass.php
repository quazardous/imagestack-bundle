<?php

namespace Quazardous\ImagestackBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ImageBackendFactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        
        if (!$container->has('quazardous_imagestack.image_backend_provider')) {
            return;
        }
        
        $definition = $container->findDefinition(
            'quazardous_imagestack.image_backend_provider'
        );
        
        $taggedServices = $container->findTaggedServiceIds('quazardous_imagestack.image_backend_factory');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'registerImageBackendFactory',
                array(new Reference($id))
            );
        }
    }
}