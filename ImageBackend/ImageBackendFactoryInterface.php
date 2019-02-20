<?php

namespace Quazardous\ImagestackBundle\ImageBackend;

interface ImageBackendFactoryInterface
{
    public function getType();
    public function createImageBackend(array $options);
}