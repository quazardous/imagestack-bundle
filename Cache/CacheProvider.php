<?php

namespace Quazardous\ImagestackBundle\Cache;

use Doctrine\Common\Cache\Cache;

class CacheProvider
{
    /**
     * @var CacheFactoryInterface[]
     */
    protected $cacheFactories = [];
    public function registerCacheFactory(CacheFactoryInterface $factory)
    {
        $this->cacheFactories[$factory->getType()] = $factory;
    }
    
    /**
     * @param string $type
     * @param array $options
     * @throws \RuntimeException
     * @return Cache
     */
    public function createCache(string $type, array $options = [])
    {
        if (empty($this->cacheFactories[$type])) throw new \RuntimeException(sprintf('No factory for type %s', $type));
        return $this->cacheFactories[$type]->createCache($options);
    }
}
