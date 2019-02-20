<?php

namespace Quazardous\ImagestackBundle\ImageOptimizer;

interface ImageOptimizerFactoryInterface
{
    public function getType();
    public function createImageOptimizer(array $options);
}