<?php

namespace Quazardous\ImagestackBundle\ImageOptimizer;

use ImageStack\ImageOptimizer\ImageOptimizerInterface;

class ImageOptimizerProvider
{
    /**
     * @var ImageOptimizerFactoryInterface[]
     */
    protected $imageOptimizerFactories = [];
    public function registerImageOptimizerFactory(ImageOptimizerFactoryInterface $factory)
    {
        $this->imageOptimizerFactories[$factory->getType()] = $factory;
    }
    
    /**
     * @param string $type
     * @param array $options
     * @throws \RuntimeException
     * @return ImageOptimizerInterface
     */
    public function createImageOptimizer(string $type, array $options = [])
    {
        if (empty($this->imageOptimizerFactories[$type])) throw new \RuntimeException(sprintf('No factory for type %s', $type));
        return $this->imageOptimizerFactories[$type]->createImageOptimizer($options);
    }
}
