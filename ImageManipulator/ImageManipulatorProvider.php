<?php

namespace Quazardous\ImagestackBundle\ImageManipulator;

use ImageStack\Api\ImageManipulatorInterface;

class ImageManipulatorProvider
{
    /**
     * @var ImageManipulatorFactoryInterface[]
     */
    protected $imageManipulatorFactories = [];
    public function registerImageManipulatorFactory(ImageManipulatorFactoryInterface $factory)
    {
        $this->imageManipulatorFactories[$factory->getType()] = $factory;
    }
    
    /**
     * @param string $type
     * @param array $options
     * @throws \RuntimeException
     * @return ImageManipulatorInterface
     */
    public function createImageManipulator(string $type, array $options = [])
    {
        if (empty($this->imageManipulatorFactories[$type])) throw new \RuntimeException(sprintf('No factory for type %s', $type));
        return $this->imageManipulatorFactories[$type]->createImageManipulator($options);
    }
}
