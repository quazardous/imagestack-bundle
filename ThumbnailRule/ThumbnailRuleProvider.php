<?php

namespace Quazardous\ImagestackBundle\ThumbnailRule;

use ImageStack\ImageOptimizer\ImageOptimizerInterface;

class ThumbnailRuleProvider
{
    /**
     * @var ThumbnailRuleFactoryInterface[]
     */
    protected $thumbnailRuleFactories = [];
    public function registerThumbnailRuleFactory(ThumbnailRuleFactoryInterface $factory)
    {
        $this->thumbnailRuleFactories[$factory->getType()] = $factory;
    }
    
    /**
     * @param mixed $definition
     * @param string $type
     * @throws \RuntimeException
     * @return ImageOptimizerInterface
     */
    public function createThumbnailRule($definition, string $type = null)
    {
        if (empty($type)) {
            if (is_string($definition)) {
                $type = $definition;
            } else {
                $type = 'pattern';
            }
        }
        if (empty($this->thumbnailRuleFactories[$type])) throw new \RuntimeException(sprintf('No factory for type %s', $type));
        return $this->thumbnailRuleFactories[$type]->createThumbnailRule($definition);
    }
}
