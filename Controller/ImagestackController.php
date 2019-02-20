<?php

namespace Quazardous\ImagestackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Quazardous\ImagestackBundle\ImageBackend\ImageBackendProvider;
use Symfony\Component\HttpFoundation\Response;
use Quazardous\ImagestackBundle\ImageManipulator\ImageManipulatorProvider;
use Quazardous\ImagestackBundle\ImageOptimizer\ImageOptimizerProvider;
use Quazardous\ImagestackBundle\ImageStack\ImageStackManager;
use ImageStack\Api\Exception\ImageNotFoundException;
use ImageStack\ImagePath;
use ImageStack\ImageStack;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;

class ImagestackController extends AbstractController
{

    /**
     * @var ImageStack
     */
    protected $imageStack;
    
    public function __construct(?ImageStack $imageStack)
    {
        if (is_null($imageStack)) throw new \InvalidArgumentException('Stack is NULL. Maybe you forget to define an alias for quazardous_imagestack.default_stack ?');
        $this->imageStack = $imageStack;
    }
    
    public function image(string $path, Request $request)
    {
        $prefix = $request->getPathInfo();
        $prefix = substr($prefix, 0, strlen($path) * -1);
        $prefix = rtrim($prefix, '/');

        try {
            $image = $this->imageStack->stackImage(new ImagePath($path, $prefix));
        } catch (ImageNotFoundException $e) {
            throw new HttpException(404, 'Image not found');
        }
        
        if (empty($image)) {
            throw new HttpException(404, sprintf('%s not found', $path));
        }
        
        $response = new Response($image->getBinaryContent());
        $response->headers->set('Content-Type', $image->getMimeType());
        
        return $response;
    }
}
