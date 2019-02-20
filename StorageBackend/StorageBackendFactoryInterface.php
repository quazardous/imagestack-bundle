<?php

namespace Quazardous\ImagestackBundle\StorageBackend;

interface StorageBackendFactoryInterface
{
    public function getType();
    public function createStorageBackend(array $options);
}