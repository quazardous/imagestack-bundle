<?php

namespace Quazardous\ImagestackBundle\PathRule;

use ImageStack\ImageOptimizer\ImageOptimizerInterface;

class PathRuleProvider
{
    /**
     * @var PathRuleFactoryInterface[]
     */
    protected $pathRuleFactories = [];
    public function registerPathRuleFactory(PathRuleFactoryInterface $factory)
    {
        $this->pathRuleFactories[$factory->getType()] = $factory;
    }
    
    /**
     * @param string $type
     * @param array $options
     * @throws \RuntimeException
     * @return ImageOptimizerInterface
     */
    public function createPathRule($definition, string $type = null)
    {
        if (empty($type)) {
            if (is_string($definition)) {
                $type = $definition;
            } else {
                $type = 'pattern';
            }
        }
        if (empty($this->pathRuleFactories[$type])) throw new \RuntimeException(sprintf('No factory for type %s', $type));
        return $this->pathRuleFactories[$type]->createPathRule($definition);
    }
}
