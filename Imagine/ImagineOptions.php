<?php

namespace Quazardous\ImagestackBundle\Imagine;

class ImagineOptions implements ImagineOptionsInterface
{
    protected $options = [];
    public function __construct(array $options)
    {
        $this->options = $options;
    }
    
    public function getOptions()
    {
        return $this->options;
    }
}