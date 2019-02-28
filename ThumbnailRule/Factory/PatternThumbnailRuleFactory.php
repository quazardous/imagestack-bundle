<?php

namespace Quazardous\ImagestackBundle\ThumbnailRule\Factory;

use Quazardous\ImagestackBundle\ThumbnailRule\ThumbnailRuleFactoryInterface;
use ImageStack\ImageManipulator\ThumbnailRule\PatternThumbnailRule;

class PatternThumbnailRuleFactory implements ThumbnailRuleFactoryInterface
{
    protected $defaultThumbnailFilter;
    public function __construct(string $defaultThumbnailFilter)
    {
        $this->defaultThumbnailFilter = $defaultThumbnailFilter;
    }
    
    public function getType()
    {
        return 'pattern';
    }

    public function createThumbnailRule(array $definition)
    {
        if ([0, 1, 2] === array_keys($definition)) {
            // pattern rule shortcut with filter
            $definition = [
                'pattern' => $definition[0],
                'format' => $definition[1],
                'filter' => $definition[2],
            ];
        } elseif ([0, 1] === array_keys($definition)) {
            // pattern rule shortcut
            $definition = [
                'pattern' => $definition[0],
                'format' => $definition[1],
            ];
        }
        if (preg_match('/^ *function *\(/', $definition['format'])) {
            eval('$definition[\'format\'] = ' . rtrim($definition['format'], ';') . ';');
        }
        if (empty($definition['pattern'])) throw new \RuntimeException('Missing mandatory option pattern');
        if (!isset($definition['format'])) throw new \RuntimeException('Missing mandatory option format');
        $definition += [
            'filter' => $this->defaultThumbnailFilter,
        ];
        
        return new PatternThumbnailRule($definition['pattern'], $definition['format'], $definition['filter']);
    }
    
}