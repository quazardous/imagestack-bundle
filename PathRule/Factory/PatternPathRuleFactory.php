<?php

namespace Quazardous\ImagestackBundle\PathRule\Factory;

use Quazardous\ImagestackBundle\PathRule\PathRuleFactoryInterface;
use ImageStack\ImageBackend\PathRule\PatternPathRule;

class PatternPathRuleFactory implements PathRuleFactoryInterface
{
    public function getType()
    {
        return 'pattern';
    }

    public function createPathRule(array $definition)
    {
        if ([0, 1] === array_keys($definition)) {
            // pattern rule shortcut
            $definition = [
                'pattern' => $definition[0],
                'output' => $definition[1],
            ];
        }
        if (empty($definition['pattern'])) throw new \RuntimeException('Missing mandatory option pattern');
        if (empty($definition['output'])) throw new \RuntimeException('Missing mandatory option output');
        return new PatternPathRule($definition['pattern'], $definition['output']);
    }
    
}