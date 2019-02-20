<?php

namespace Quazardous\ImagestackBundle\ImageBackend\Factory;

use Quazardous\ImagestackBundle\ImageBackend\ImageBackendFactoryInterface;
use ImageStack\ImageBackend\HttpImageBackend;

class HttpImageBackendFactory implements ImageBackendFactoryInterface
{
    public function getType()
    {
        return 'http';
    }

    public function createImageBackend(array $definition)
    {
        if (empty($definition['root_url'])) throw new \RuntimeException('Missing mandatory option root_url');
        $rootUrl = $definition['root_url'];
        unset($definition['root_url']);
        return new HttpImageBackend($rootUrl, $definition);
    }
    
}