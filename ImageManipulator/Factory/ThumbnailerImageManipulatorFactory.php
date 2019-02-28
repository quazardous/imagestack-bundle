<?php

namespace Quazardous\ImagestackBundle\ImageManipulator\Factory;

use Quazardous\ImagestackBundle\ImageManipulator\ImageManipulatorFactoryInterface;
use Quazardous\ImagestackBundle\ThumbnailRule\ThumbnailRuleProvider;
use ImageStack\ImageManipulator\ThumbnailerImageManipulator;
use Imagine\Image\ImagineInterface;
use Quazardous\ImagestackBundle\Imagine\ImagineOptionsInterface;

class ThumbnailerImageManipulatorFactory implements ImageManipulatorFactoryInterface
{
    /**
     * @var ImagineInterface
     */
    protected $imagine;
    
    /**
     * @var ImagineOptionsInterface
     */
    protected $imagineOptions;
    
    /**
     * @var ThumbnailRuleProvider
     */
    protected $thumbnailRuleProvider;
    
    public function __construct(ImagineInterface $imagine, ImagineOptionsInterface $imagineOptions, ThumbnailRuleProvider $thumbnailRuleProvider)
    {
        $this->imagine = $imagine;
        $this->imagineOptions = $imagineOptions;
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
        $definition['imagine_options'] = array_replace($definition['imagine_options'] ?? [], $this->imagineOptions->getOptions());
        return new ThumbnailerImageManipulator($this->imagine, $rules, $definition);
    }
    
}