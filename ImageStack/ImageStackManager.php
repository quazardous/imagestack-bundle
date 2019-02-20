<?php

namespace Quazardous\ImagestackBundle\ImageStack;

use ImageStack\ImageStack;
use Quazardous\ImagestackBundle\ImageBackend\ImageBackendProvider;
use Quazardous\ImagestackBundle\StorageBackend\StorageBackendProvider;
use Quazardous\ImagestackBundle\ImageManipulator\ImageManipulatorProvider;
use ImageStack\Image;

class ImageStackManager
{
    
    /**
     * @var ImageBackendProvider
     */
    protected $imageBackendProvider;
    
    /**
     * @var StorageBackendProvider
     */
    protected $storageBackendProvider;

    /**
     * @var ImageManipulatorProvider
     */
    protected $imageManipulatorProvider;

    
    public function __construct(ImageBackendProvider $imageBackendProvider, StorageBackendProvider $storageBackendProvider, ImageManipulatorProvider $imageManipulatorProvider)
    {
        $this->imageBackendProvider = $imageBackendProvider;
        $this->storageBackendProvider = $storageBackendProvider;
        $this->imageManipulatorProvider = $imageManipulatorProvider;
    }
    
    public function createImageStack($imageBackend, $storageBackend, array $imageManipulators = [])
    {
        if (is_array($imageBackend)) {
            if (is_array($imageBackend)) {
                $type = $imageBackend['type'];
                unset($imageBackend['type']);
                $imageBackend = $this->imageBackendProvider->createImageBackend($type, $imageBackend);
            }
        }
        if (is_array($storageBackend)) {
            if (is_array($storageBackend)) {
                $type = $storageBackend['type'];
                unset($storageBackend['type']);
                $storageBackend = $this->storageBackendProvider->createStorageBackend($type, $storageBackend);
            }
        }
        $manipulators = [];
        foreach ($imageManipulators as $imageManipulator) {
            if (is_array($imageManipulator)) {
                $type = $imageManipulator['type'];
                unset($imageManipulator['type']);
                $imageManipulator = $this->imageManipulatorProvider->createImageManipulator($type, $imageManipulator);
            }
            $manipulators[] = $imageManipulator;
        }
        $stack = new ImageStack($imageBackend, $storageBackend, $manipulators);
        return $stack;
    }
}
