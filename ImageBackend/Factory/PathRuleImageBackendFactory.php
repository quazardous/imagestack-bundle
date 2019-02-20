<?php

namespace Quazardous\ImagestackBundle\ImageBackend\Factory;

use Quazardous\ImagestackBundle\ImageBackend\ImageBackendFactoryInterface;
use Quazardous\ImagestackBundle\ImageBackend\ImageBackendProvider;
use Quazardous\ImagestackBundle\PathRule\PathRuleProvider;
use ImageStack\ImageBackend\PathRuleImageBackend;

class PathRuleImageBackendFactory implements ImageBackendFactoryInterface
{
    /**
     * @var ImageBackendProvider
     */
    protected $imageBackendProvider;
    /**
     * @var PathRuleProvider
     */
    protected $pathRuleProvider;
    
    public function __construct(ImageBackendProvider $imageBackendProvider, PathRuleProvider $pathRuleProvider)
    {
        $this->imageBackendProvider = $imageBackendProvider;
        $this->pathRuleProvider = $pathRuleProvider;
    }
    
    public function getType()
    {
        return 'path_rule';
    }

    public function createImageBackend(array $definition)
    {
        if (empty($definition['backend'])) throw new \RuntimeException('Missing mandatory option backend');
        $backend = $definition['backend'];
        if (is_array($backend)) {
            $type = $backend['type'];
            unset($backend['type']);
            $backend = $this->imageBackendProvider->createImageBackend($type, $backend);
        }
        
        $rules = [];
        if (isset($definition['rules'])) {
            foreach ((array)$definition['rules'] as $rule) {
                if (is_array($rule)) {
                    $type = $rule['type'] ?? null;
                    unset($rule['type']);
                    $rule = $this->pathRuleProvider->createPathRule($rule, $type);
                }
                $rules[] = $rule;
            }
            unset($definition['rules']);
        }
        return new PathRuleImageBackend($backend, $rules, $definition);
    }
    
}