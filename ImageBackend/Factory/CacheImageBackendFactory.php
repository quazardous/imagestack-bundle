<?php

namespace Quazardous\ImagestackBundle\ImageBackend\Factory;

use Quazardous\ImagestackBundle\ImageBackend\ImageBackendFactoryInterface;
use ImageStack\ImageBackend\CacheImageBackend;
use Quazardous\ImagestackBundle\ImageBackend\ImageBackendProvider;
use Quazardous\ImagestackBundle\Cache\CacheProvider;

class CacheImageBackendFactory implements ImageBackendFactoryInterface
{
    /**
     * @var ImageBackendProvider
     */
    protected $imageBackendProvider;
    /**
     * @var CacheProvider
     */
    protected $cacheProvider;
    
    public function __construct(ImageBackendProvider $imageBackendProvider, CacheProvider $cacheProvider)
    {
        $this->imageBackendProvider = $imageBackendProvider;
        $this->cacheProvider = $cacheProvider;
    }
    
    public function getType()
    {
        return 'cache';
    }

    public function createImageBackend(array $definition)
    {
        if (empty($definition['backend'])) throw new \RuntimeException('Missing mandatory option backend');
        if (empty($definition['cache'])) throw new \RuntimeException('Missing mandatory option cache');
        $backend = $definition['backend'];
        $cache = $$definition['cache'];
        unset($definition['backend']);
        unset($definition['cache']);
        if (is_array($backend)) {
            $type = $backend['type'];
            unset($backend['type']);
            $backend = $this->imageBackendProvider->createImageBackend($type, $backend);
        }
        if (is_array($cache)) {
            $type = $cache['type'];
            unset($cache['type']);
            $cache = $this->cacheProvider->createCache($type, $cache);
        }
        return new CacheImageBackend($backend, $cache, $definition);
    }
    
}