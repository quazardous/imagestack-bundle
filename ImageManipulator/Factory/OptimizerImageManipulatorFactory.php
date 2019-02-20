<?php

namespace Quazardous\ImagestackBundle\ImageManipulator\Factory;

use Quazardous\ImagestackBundle\ImageManipulator\ImageManipulatorFactoryInterface;
use ImageStack\ImageManipulator\OptimizerImageManipulator;
use Quazardous\ImagestackBundle\ImageOptimizer\ImageOptimizerProvider;

class OptimizerImageManipulatorFactory implements ImageManipulatorFactoryInterface
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
        return 'optimizer';
    }

    public function createImageManipulator(array $definition)
    {
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
        return new OptimizerImageManipulator($optimizers);
    }
    
}