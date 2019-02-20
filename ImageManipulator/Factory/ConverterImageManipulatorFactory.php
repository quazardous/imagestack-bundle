<?php

namespace Quazardous\ImagestackBundle\ImageManipulator\Factory;

use Quazardous\ImagestackBundle\ImageManipulator\ImageManipulatorFactoryInterface;
use ImageStack\ImageManipulator\ConverterImageManipulator;
use Imagine\Image\ImagineInterface;

class ConverterImageManipulatorFactory implements ImageManipulatorFactoryInterface
{
    /**
     * @var ImagineInterface
     */
    protected $imagine;
    public function __construct(ImagineInterface $imagine)
    {
        $this->imagine = $imagine;
    }
    
    public function getType()
    {
        return 'converter';
    }

    public function createImageManipulator(array $definition)
    {
        if (empty($definition['conversions'])) throw new \RuntimeException('Missing mandatory option conversions');
        $conversions = $definition['conversions'];
        unset($definition['conversions']);
        return new ConverterImageManipulator($this->imagine, $conversions, $definition);
    }
    
}