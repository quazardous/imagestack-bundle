<?php

namespace Quazardous\ImagestackBundle\StorageBackend\Factory;

use Quazardous\ImagestackBundle\StorageBackend\StorageBackendFactoryInterface;
use ImageStack\StorageBackend\FileStorageBackend;

class FileStorageBackendFactory implements StorageBackendFactoryInterface
{
    public function getType()
    {
        return 'file';
    }

    public function createStorageBackend(array $definition)
    {
        if (empty($definition['root'])) throw new \RuntimeException('Missing mandatory option root');
        $root = $definition['root'];
        unset($definition['root']);
        return new FileStorageBackend($root, $definition);
    }
    
}