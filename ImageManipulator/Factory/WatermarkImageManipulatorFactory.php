<?php

namespace Quazardous\ImagestackBundle\ImageManipulator\Factory;

use Quazardous\ImagestackBundle\ImageManipulator\ImageManipulatorFactoryInterface;
use Quazardous\ImagestackBundle\ThumbnailRule\ThumbnailRuleProvider;
use ImageStack\ImageManipulator\ThumbnailerImageManipulator;
use Imagine\Image\ImagineInterface;
use ImageStack\ImageManipulator\WatermarkImageManipulator;
use Quazardous\ImagestackBundle\Imagine\ImagineOptionsInterface;

class WatermarkImageManipulatorFactory implements ImageManipulatorFactoryInterface
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
        return 'watermark';
    }

    public function createImageManipulator(array $definition)
    {
        if (empty($definition['watermark'])) throw new \RuntimeException('Missing mandatory option watermark');
        $watermark = $definition['watermark'];
        unset($definition['watermark']);
        if (isset($definition['anchor'])) {
            if (is_string($definition['anchor'])) {
                $anchor = 0x00;
                foreach (preg_split('/[^A-Z]+/', strtoupper($definition['anchor'])) as $v) {
                    $c = WatermarkImageManipulator::class . '::ANCHOR_' . $v;
                    if (!defined($c)) {
                        throw new \InvalidArgumentException(sprintf('Invalid anchor value: %s', $v));
                    }
                    $anchor |= constant($c);
                }
                $definition['anchor'] = $anchor;
            }
        }
        if (isset($definition['repeat'])) {
            if (is_string($definition['repeat'])) {
                $repeat = 0x00;
                foreach (preg_split('/[^A-Z]+/', strtoupper($definition['repeat'])) as $v) {
                    $c = WatermarkImageManipulator::class . '::REPEAT_' . $v;
                    if (!defined($c)) {
                        throw new \InvalidArgumentException(sprintf('Invalid repeat value: %s', $v));
                    }
                    $repeat |= constant($c);
                }
                $definition['repeat'] = $repeat;
            }
        }
        if (isset($definition['reduce'])) {
            if (is_string($definition['reduce'])) {
                $reduce = 0x00;
                foreach (preg_split('/[^A-Z]+/', strtoupper($definition['reduce'])) as $v) {
                    $c = WatermarkImageManipulator::class . '::REDUCE_' . $v;
                    if (!defined($c)) {
                        throw new \InvalidArgumentException(sprintf('Invalid reduce value: %s', $v));
                    }
                    $reduce |= constant($c);
                }
                $definition['reduce'] = $reduce;
            }
        }
        $definition['imagine_options'] = array_replace($definition['imagine_options'] ?? [], $this->imagineOptions->getOptions());
        return new WatermarkImageManipulator($this->imagine, $watermark, $definition);
    }
    
}