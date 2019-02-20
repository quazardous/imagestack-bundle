<?php

namespace Quazardous\ImagestackBundle\ThumbnailRule;

interface ThumbnailRuleFactoryInterface
{
    public function getType();
    public function createThumbnailRule(array $definition);
}