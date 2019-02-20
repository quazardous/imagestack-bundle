<?php

namespace Quazardous\ImagestackBundle\ImageOptimizer\Factory;

use Quazardous\ImagestackBundle\ImageOptimizer\ImageOptimizerFactoryInterface;
use ImageStack\ImageOptimizer\GifsicleImageOptimizer;

class GifsicleImageOptimizerFactory implements ImageOptimizerFactoryInterface
{
    protected $defaultDefinition = [];
    public function __construct(array $defaultDefinition = [])
    {
        $this->defaultDefinition = $defaultDefinition;
    }
    
    public function getType()
    {
        return 'gifsicle';
    }

    public function createImageOptimizer(array $definition)
    {
        $definition += $this->defaultDefinition;
        return new GifsicleImageOptimizer($definition);
    }
    
}