<?php

namespace Quazardous\ImagestackBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Quazardous\ImagestackBundle\DependencyInjection\Compiler\ImageBackendFactoryCompilerPass;
use Quazardous\ImagestackBundle\DependencyInjection\Compiler\StorageBackendFactoryCompilerPass;
use Quazardous\ImagestackBundle\DependencyInjection\Compiler\ImageManipulatorFactoryCompilerPass;
use Quazardous\ImagestackBundle\DependencyInjection\Compiler\ImageOptimizerFactoryCompilerPass;
use Quazardous\ImagestackBundle\DependencyInjection\Compiler\ThumbnailRuleFactoryCompilerPass;
use Quazardous\ImagestackBundle\DependencyInjection\Compiler\PathRuleFactoryCompilerPass;
use Quazardous\ImagestackBundle\DependencyInjection\Compiler\CacheFactoryCompilerPass;

class QuazardousImagestackBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        $container->addCompilerPass(new ImageBackendFactoryCompilerPass());
        $container->addCompilerPass(new StorageBackendFactoryCompilerPass());
        $container->addCompilerPass(new ImageManipulatorFactoryCompilerPass());
        $container->addCompilerPass(new ImageOptimizerFactoryCompilerPass());
        $container->addCompilerPass(new ThumbnailRuleFactoryCompilerPass());
        $container->addCompilerPass(new PathRuleFactoryCompilerPass());
        $container->addCompilerPass(new CacheFactoryCompilerPass());
    }
}