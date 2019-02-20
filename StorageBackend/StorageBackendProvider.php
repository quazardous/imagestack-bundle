<?php

namespace Quazardous\ImagestackBundle\StorageBackend;

use ImageStack\Api\StorageBackendInterface;

class StorageBackendProvider
{
    /**
     * @var StorageBackendFactoryInterface[]
     */
    protected $storageBackendFactories = [];
    public function registerStorageBackendFactory(StorageBackendFactoryInterface $factory)
    {
        $this->storageBackendFactories[$factory->getType()] = $factory;
    }
    
    /**
     * @param string $type
     * @param array $options
     * @throws \RuntimeException
     * @return StorageBackendInterface
     */
    public function createStorageBackend(string $type, array $options = [])
    {
        if (empty($this->storageBackendFactories[$type])) throw new \RuntimeException(sprintf('No factory for type %s', $type));
        return $this->storageBackendFactories[$type]->createStorageBackend($options);
    }
}
