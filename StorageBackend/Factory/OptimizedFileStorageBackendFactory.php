<?php

namespace Quazardous\ImagestackBundle\StorageBackend\Factory;

use Quazardous\ImagestackBundle\StorageBackend\StorageBackendFactoryInterface;
use ImageStack\StorageBackend\OptimizedFileStorageBackend;
use Quazardous\ImagestackBundle\ImageOptimizer\ImageOptimizerProvider;

class OptimizedFileStorageBackendFactory implements StorageBackendFactoryInterface
{
    /**
     * @var ImageOptimizerProvider
     */
    protected $imageOptimizerProvider;
    
    public function __construct(ImageOptimizerProvider $imageOptimizerProvider)
    {
        $this->imageOptimizerProvider = $imageOptimizerProvider;
    }
    
    public function getType()
    {
        return 'optimized_file';
    }

    public function createStorageBackend(array $definition)
    {
        if (empty($definition['root'])) throw new \RuntimeException('Missing mandatory option root');
        $root = $definition['root'];
        unset($definition['root']);
        $optimizers = [];
        if (isset($definition['optimizers'])) {
            foreach ((array)$definition['optimizers'] as $optimizer) {
                if (is_array($optimizer)) {
                    $type = $optimizer['type'];
                    unset($optimizer['type']);
                    $optimizer = $this->imageOptimizerProvider->createImageOptimizer($type, $optimizer);
                }
                $optimizers[] = $optimizer;
            }
            unset($definition['optimizers']);
        }
        return new OptimizedFileStorageBackend($root, $optimizers, $definition);
    }
    
}