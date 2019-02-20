<?php

namespace Quazardous\ImagestackBundle\Cache\Factory;

use Quazardous\ImagestackBundle\Cache\CacheFactoryInterface;
use ImageStack\Cache\RawFileCache;

class RawFileCacheFactory implements CacheFactoryInterface
{
    
    public function getType()
    {
        return 'raw_file';
    }

    public function createCache(array $definition)
    {
        if (empty($definition['root'])) throw new \RuntimeException('Missing mandatory option root');
        $root = $definition['root'];
        unset($definition['root']);
        return new RawFileCache($root, $definition);
    }
    
}