<?php

namespace Quazardous\ImagestackBundle\ImageManipulator\Factory;

use Quazardous\ImagestackBundle\ImageManipulator\ImageManipulatorFactoryInterface;
use Quazardous\ImagestackBundle\ThumbnailRule\ThumbnailRuleProvider;
use ImageStack\ImageManipulator\ThumbnailerImageManipulator;
use Imagine\Image\ImagineInterface;

class ThumbnailerImageManipulatorFactory implements ImageManipulatorFactoryInterface
{
    /**
     * @var ImagineInterface
     */
    protected $imagine;
    
    /**
     * @var ThumbnailRuleProvider
     */
    protected $thumbnailRuleProvider;
    
    public function __construct(ImagineInterface $imagine, ThumbnailRuleProvider $thumbnailRuleProvider)
    {
        $this->imagine = $imagine;
        $this->thumbnailRuleProvider = $thumbnailRuleProvider;
    }
    
    public function getType()
    {
        return 'thumbnailer';
    }

    public function createImageManipulator(array $definition)
    {
        $rules = [];
        if (isset($definition['rules'])) {
            foreach ((array)$definition['rules'] as $rule) {
                if (is_array($rule)) {
                    $type = $rule['type'] ?? null;
                    unset($rule['type']);
                    $rule = $this->thumbnailRuleProvider->createThumbnailRule($rule, $type);
                }
                $rules[] = $rule;
            }
            unset($definition['rules']);
        }
        return new ThumbnailerImageManipulator($this->imagine, $rules, $definition);
    }
    
}