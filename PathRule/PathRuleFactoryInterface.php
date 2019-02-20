<?php

namespace Quazardous\ImagestackBundle\PathRule;

interface PathRuleFactoryInterface
{
    public function getType();
    public function createPathRule(array $definition);
}