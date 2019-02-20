<?php

namespace Quazardous\ImagestackBundle\Cache;

interface CacheFactoryInterface
{
    public function getType();
    public function createCache(array $options);
}