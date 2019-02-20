<?php

namespace Quazardous\ImagestackBundle\ImageBackend\Factory;

use Quazardous\ImagestackBundle\ImageBackend\ImageBackendFactoryInterface;
use ImageStack\ImageBackend\CallbackImageBackend;

class CallbackImageBackendFactory implements ImageBackendFactoryInterface
{
    
    public function getType()
    {
        return 'callback';
    }

    public function createImageBackend(array $definition)
    {
        if (empty($definition['callback'])) throw new \RuntimeException('Missing mandatory option callback');
        $callback = $definition['callback'];
        unset($definition['callback']);
     
        return new CallbackImageBackend($callback, $callback);
    }
    
}