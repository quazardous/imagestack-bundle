<?php

namespace Quazardous\ImagestackBundle\ImageOptimizer\Factory;

use Quazardous\ImagestackBundle\ImageOptimizer\ImageOptimizerFactoryInterface;
use ImageStack\ImageOptimizer\JpegtranImageOptimizer;

class JpegtranImageOptimizerFactory implements ImageOptimizerFactoryInterface
{
    protected $defaultDefinition = [];
    public function __construct(array $defaultDefinition = [])
    {
        $this->defaultDefinition = $defaultDefinition;
    }
    
    public function getType()
    {
        return 'jpegtran';
    }

    public function createImageOptimizer(array $definition)
    {
        $definition += $this->defaultDefinition;
        return new JpegtranImageOptimizer($definition);
    }
    
}