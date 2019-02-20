<?php

namespace Quazardous\ImagestackBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ImageManipulatorFactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        
        if (!$container->has('quazardous_imagestack.image_manipulator_provider')) {
            return;
        }
        
        $definition = $container->findDefinition(
            'quazardous_imagestack.image_manipulator_provider'
        );
        
        $taggedServices = $container->findTaggedServiceIds('quazardous_imagestack.image_manipulator_factory');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'registerImageManipulatorFactory',
                array(new Reference($id))
            );
        }
    }
}