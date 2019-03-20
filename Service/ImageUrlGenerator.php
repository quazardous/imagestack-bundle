<?php

namespace Quazardous\ImagestackBundle\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ImageUrlGenerator
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;
    
    protected $defaultImagestackRoute;
    protected $imagestackAssetsVersion;
    public function __construct(UrlGeneratorInterface $urlGenerator, string $defaultImagestackRoute, ?string $imagestackAssetsVersion)
    {
        $this->urlGenerator = $urlGenerator;
        $this->defaultImagestackRoute = $defaultImagestackRoute;
        $this->imagestackAssetsVersion = $imagestackAssetsVersion;
    }
    
    /**
     * @param string $path
     * @param string $style
     * @param int $referenceType
     * @param string $name
     * @return string
     */
    public function generateUrl(string $path, string $style = '' , $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH, string $route = null)
    {
        if (empty($route)) $route = $this->defaultImagestackRoute;
        $parameters = ['path' => ($style ? $style . '/' : '') . $path];
        $url = $this->urlGenerator->generate($route, $parameters, $referenceType);
        if ($this->imagestackAssetsVersion) {
            $url .= '?' . $this->imagestackAssetsVersion;
        }
        return $url;
    }
}