<?php

namespace Quazardous\ImagestackBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ThumbnailRuleFactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        
        if (!$container->has('quazardous_imagestack.thumbnail_rule_provider')) {
            return;
        }
        
        $definition = $container->findDefinition(
            'quazardous_imagestack.thumbnail_rule_provider'
        );
        
        $taggedServices = $container->findTaggedServiceIds('quazardous_imagestack.thumbnail_rule_factory');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'registerThumbnailRuleFactory',
                array(new Reference($id))
            );
        }
    }
}