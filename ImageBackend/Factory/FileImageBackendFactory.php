<?php

namespace Quazardous\ImagestackBundle\ImageBackend\Factory;

use Quazardous\ImagestackBundle\ImageBackend\ImageBackendFactoryInterface;
use ImageStack\ImageBackend\FileImageBackend;

class FileImageBackendFactory implements ImageBackendFactoryInterface
{
    public function getType()
    {
        return 'file';
    }

    public function createImageBackend(array $definition)
    {
        if (empty($definition['root'])) throw new \RuntimeException('Missing mandatory option root');
        $root = $definition['root'];
        unset($definition['root']);
        return new FileImageBackend($root, $definition);
    }
    
}