<?php

namespace Quazardous\ImagestackBundle\ImageManipulator;

interface ImageManipulatorFactoryInterface
{
    public function getType();
    public function createImageManipulator(array $options);
}