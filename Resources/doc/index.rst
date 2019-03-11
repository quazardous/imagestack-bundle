Imagestack Bundle
=================

Installation
------------

.. code:: bash

    composer require quazardous/imagestack-bundle

Config
------

NB: for SF4


Imagestack config:

.. code:: yaml

   # config/packages/quazardous_imagestack.yaml
   
   parameters:
      # define the main/default imagestack route (see routing)
      quazardous_imagestack.default_imagestack_route: 'imagestack_public'
      # this will add ?20190211170600 at the end of all image URL (usefull for cache stuff)
      quazardous_imagestack.imagestack_assets_version: '20190211170600'
      
   quazardous_imagestack:
      # nothing yet
      
   services:
      # default configuration for services in *this* file
      _defaults:
          autowire: true      # Automatically injects dependencies in your services.
          autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.
          public: false
      
      # define a simple file backend to retrieve images from a non public folder
      app.imagestack_image_backend.images_folder:
          class: ImageStack\ImageBackend\FileImageBackend
          # we can use factories to handle nested definitions
          factory: 'quazardous_imagestack.image_backend_provider:createImageBackend'
          arguments:
              $type: 'file'
              $options:
                  root: '%kernel.project_dir%/images'
   
      # cool backend that does cool stufs
      app.imagestack_image_backend.cool_stuff:
          class: App\ImageStack\CoolStuffImageBackend
          arguments:
              $root: '%kernel.project_dir%/images'
              $doSomethingCool: true # you see it does cool stuff !
   
      # backend fetch images, then tries to fetch cooler images
      app.imagestack_image_backend.try_many_backends:
          class: ImageStack\ImageBackend\SequentialImageBackend
          factory: 'quazardous_imagestack.image_backend_provider:createImageBackend'
          arguments:
              $type: 'sequential'
              $options:
                  backends:
                      - '@app.imagestack_image_backend.images_folder'
                      - '@app.imagestack_image_backend.cool_stuff' # if we don't find the image in the folder we try something cool
   
      # we define a technical backend that knows how to rewrite image path
      app.imagestack_image_backend.rewrite_path:
          class: ImageStack\ImageBackend\PathRuleImageBackend
          factory: 'quazardous_imagestack.image_backend_provider:createImageBackend'
          arguments:
              $type: 'path_rule'
              $options:
                  backend: '@app.imagestack_image_backend.try_many_backends'
                  rules: # the rules will just rewrite the path and pass it to the inner backend
                      - ['#^((style|format|admin)/[^/]+/)(.*)$#', [3]] # path is the 3rd parenthesis, style/foo/a/b/c/bar.jpg -> a/b/c/bar.jpg
   
      # we define a storage backend to store generated images in the public folder
      app.imagestack_storage_backend.public_images:
          class: ImageStack\StorageBackend\OptimizedFileStorageBackend
          factory: 'quazardous_imagestack.storage_backend_provider:createStorageBackend'
          arguments:
              $type: 'optimized_file'
              $options:
                  # using the the public web folder to store the images will allow the http server to access images next time
                  root: '%kernel.project_dir%/public'
                  use_prefix: true # important: use the route prefix (before the path) to store the image
                  # we will use optimizer before saving the images
                  optimizers:
                      - '@quazardous_imagestack.image_optimizer.pngcrush'
                      - '@quazardous_imagestack.image_optimizer.jpegtran'
                      - '@quazardous_imagestack.image_optimizer.gifsicle'
      
      # we define a thumbailer manipulator that will use path rules to create on the fly thumbnail
      app.imagestack_image_manipulator.thumbnailer:
          class: ImageStack\ImageManipulator\ThumbnailerImageManipulator
          factory: 'quazardous_imagestack.image_manipulator_provider:createImageManipulator'
          arguments:
              $type: 'thumbnailer'
              $options:
                  rules:
                      - ['#^style/big/.*$#', '<800x500'] # < means that we want to keep with/height ratio but within the given size
                      - ['#^style/small/.*$#', '300x200'] # we crop the image at the given size
                      - ['#^style/thumb/.*$#', '100'] # quick for 100x100
                      - ['#^style/full/.*$#', true] # true will keep original size
                      - ['#^admin/preview/.*$#', '<800x500']
                      - ['#^admin/list/.*$#', '80x50']
                      - ['#^admin/mosaic/.*$#', '400']
                      - ['#^admin/full/.*$#', true] # true will keep original size
                      - ['#^format/([0-9]+)x([0-9]+)/.*$#', "function ($matches) { return sprintf('%%sx%%s', $matches[1], $matches[2]); }"] # we can use a callback to create the size parameter
                      - ['/.*/', false] # false will throw a 404 error
   
      # we put all together to define the full image stack
      app.imagestack_stack.images:
          class: ImageStack\ImageStack
          factory: 'quazardous_imagestack.image_stack_manager:createImageStack'
          arguments:
              $imageBackend: '@app.imagestack_image_backend.rewrite_path'
              $storageBackend: '@app.imagestack_storage_backend.public_images'
              $imageManipulators: ['@app.imagestack_image_manipulator.thumbnailer']
      
      # we can define this alias to let the default controller know about the main/default stack
      quazardous_imagestack.default_stack:
          alias: app.imagestack_stack.images
      
      # or we could use many stacks with many controllers
   #    app.imagestack_controller.other:
   #        autowire: false
   #        class: Quazardous\ImagestackBundle\Controller\ImagestackController
   #        arguments: 
   #            $imageStack: '@app.imagestack_stack.other_images'
   
      # the default is to use GD, but if you need Animated GIFs you can switch to Imagick
      quazardous_imagestack.imagine:
          alias: quazardous_imagestack.imagine_imagick


Routing:

.. code:: yaml

   # config/routes/imagestack.yaml
   
   imagestack_public:
      path:     /images/{path}
      controller: quazardous_imagestack.default_controller::image
      requirements:
          path: ".+" # important

Need to handle proxy and image version ? Just add some hash slug in your route !

.. code:: yaml

   # config/routes/imagestack.yaml
   
   imagestack_public:
      # Not so difficult :p
      path:     /images/a4f8e1b2/{path}
      controller: quazardous_imagestack.default_controller::image
      requirements:
          path: ".+" # important
