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
    protected $emptyPathFallback;
    public function __construct(UrlGeneratorInterface $urlGenerator, string $defaultImagestackRoute, ?string $imagestackAssetsVersion, ?string $emptyPathFallback)
    {
        $this->urlGenerator = $urlGenerator;
        $this->defaultImagestackRoute = $defaultImagestackRoute;
        $this->imagestackAssetsVersion = $imagestackAssetsVersion;
        $this->emptyPathFallback = $emptyPathFallback;
    }
    
    /**
     * @param string $path
     * @param string $style
     * @param int $referenceType
     * @param string $name
     * @return string
     */
    public function generateUrl(?string $path, string $style = '' , $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH, string $route = null)
    {
        if (empty($path)) $path = $this->emptyPathFallback;
        if (empty($path)) throw new \InvalidArgumentException('Path is empty');
        if (empty($route)) $route = $this->defaultImagestackRoute;
        $parameters = ['path' => ($style ? $style . '/' : '') . $path];
        $url = $this->urlGenerator->generate($route, $parameters, $referenceType);
        if ($this->imagestackAssetsVersion) {
            $url .= '?' . $this->imagestackAssetsVersion;
        }
        return $url;
    }
}