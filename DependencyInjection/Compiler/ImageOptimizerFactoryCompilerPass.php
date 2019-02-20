<?php

namespace Quazardous\ImagestackBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ImageOptimizerFactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        
        if (!$container->has('quazardous_imagestack.image_optimizer_provider')) {
            return;
        }
        
        $definition = $container->findDefinition(
            'quazardous_imagestack.image_optimizer_provider'
        );
        
        $taggedServices = $container->findTaggedServiceIds('quazardous_imagestack.image_optimizer_factory');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'registerImageOptimizerFactory',
                array(new Reference($id))
            );
        }
    }
}