<?php

namespace Quazardous\ImagestackBundle\ImageBackend;

use ImageStack\Api\ImageBackendInterface;

class ImageBackendProvider
{
    /**
     * @var ImageBackendFactoryInterface[]
     */
    protected $imageBackendFactories = [];
    public function registerImageBackendFactory(ImageBackendFactoryInterface $factory)
    {
        $this->imageBackendFactories[$factory->getType()] = $factory;
    }
    
    /**
     * @param string $type
     * @param array $options
     * @throws \RuntimeException
     * @return ImageBackendInterface
     */
    public function createImageBackend(string $type, array $options = [])
    {
        if (empty($this->imageBackendFactories[$type])) throw new \RuntimeException(sprintf('No factory for type %s', $type));
        return $this->imageBackendFactories[$type]->createImageBackend($options);
    }
}
