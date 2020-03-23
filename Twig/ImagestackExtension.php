<?php

namespace Quazardous\ImagestackBundle\Twig;

use Twig\Extension\AbstractExtension;
use Quazardous\ImagestackBundle\Service\ImageUrlGenerator;
use Twig\TwigFunction;
use Twig\TwigFilter;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ImagestackExtension extends AbstractExtension
{
    /**
     * @var ImageUrlGenerator
     */
    protected $imageUrlGenerator;
    public function __construct(ImageUrlGenerator $imageUrlGenerator)
    {
        $this->imageUrlGenerator = $imageUrlGenerator;
    }
    
    public function getFunctions()
    {
        return [
            new TwigFunction('imagestack', [$this, 'imagestackUrl']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('imagestack', [$this, 'imagestackUrl']),
        ];
    }
    
    public function imagestackUrl(?string $path, $style = null, $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH, $route = null)
    {
        return $this->imageUrlGenerator->generateUrl($path, $style, $referenceType, $route);
    }
}