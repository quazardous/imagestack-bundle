<?php

namespace Quazardous\ImagestackBundle\ImageManipulator\Factory;

use Quazardous\ImagestackBundle\ImageManipulator\ImageManipulatorFactoryInterface;
use ImageStack\ImageManipulator\ConverterImageManipulator;
use Imagine\Image\ImagineInterface;
use Quazardous\ImagestackBundle\Imagine\ImagineOptionsInterface;

class ConverterImageManipulatorFactory implements ImageManipulatorFactoryInterface
{
    /**
     * @var ImagineInterface
     */
    protected $imagine;
    
    /**
     * @var ImagineOptionsInterface
     */
    protected $imagineOptions;
    public function __construct(ImagineInterface $imagine, ImagineOptionsInterface $imagineOptions)
    {
        $this->imagine = $imagine;
        $this->imagineOptions = $imagineOptions;
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
        $definition['imagine_options'] = array_replace($definition['imagine_options'] ?? [], $this->imagineOptions->getOptions());
        return new ConverterImageManipulator($this->imagine, $conversions, $definition);
    }
    
}