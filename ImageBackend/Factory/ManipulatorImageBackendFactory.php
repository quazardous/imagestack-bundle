<?php

namespace Quazardous\ImagestackBundle\ImageBackend\Factory;

use Quazardous\ImagestackBundle\ImageBackend\ImageBackendFactoryInterface;
use Quazardous\ImagestackBundle\ImageBackend\ImageBackendProvider;
use ImageStack\ImageBackend\ManipulatorImageBackend;
use Quazardous\ImagestackBundle\ImageManipulator\ImageManipulatorProvider;

class ManipulatorImageBackendFactory implements ImageBackendFactoryInterface
{
    /**
     * @var ImageBackendProvider
     */
    protected $imageBackendProvider;
    /**
     * @var ImageManipulatorProvider
     */
    protected $imageManipulatorProvider;
    
    public function __construct(ImageBackendProvider $imageBackendProvider, ImageManipulatorProvider $imageManipulatorProvider)
    {
        $this->imageBackendProvider = $imageBackendProvider;
        $this->imageManipulatorProvider = $imageManipulatorProvider;
    }
    
    public function getType()
    {
        return 'manipulator';
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
        
        $manipulators = [];
        if (isset($definition['manipulators'])) {
            foreach ((array)$definition['manipulators'] as $manipulator) {
                if (is_array($manipulator)) {
                    $type = $manipulator['type'];
                    unset($manipulator['type']);
                    $manipulator = $this->imageManipulatorProvider->createImageManipulator($type, $manipulator);
                }
                $manipulators[] = $manipulator;
            }
        }
        return new ManipulatorImageBackend($backend, $manipulators);
    }
    
}