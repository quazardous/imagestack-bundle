<?php

namespace Quazardous\ImagestackBundle\ImageBackend\Factory;

use Quazardous\ImagestackBundle\ImageBackend\ImageBackendFactoryInterface;
use Quazardous\ImagestackBundle\ImageBackend\ImageBackendProvider;
use ImageStack\ImageBackend\SequentialImageBackend;

class SequentialImageBackendFactory implements ImageBackendFactoryInterface
{
    /**
     * @var ImageBackendProvider
     */
    protected $imageBackendProvider;
    
    public function __construct(ImageBackendProvider $imageBackendProvider)
    {
        $this->imageBackendProvider = $imageBackendProvider;
    }
    
    public function getType()
    {
        return 'sequential';
    }

    public function createImageBackend(array $definition)
    {
        $backends = [];
        if (isset($definition['backends'])) {
            foreach ((array)$definition['backends'] as $backend) {
                if (is_array($backend)) {
                    $type = $backend['type'];
                    unset($backend['type']);
                    $backend = $this->imageBackendProvider->createImageBackend($type, $backend);
                }
                $backends[] = $backend;
            }
        }
        return new SequentialImageBackend($backends, $definition);
    }
    
}