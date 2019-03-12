# ImageStack Bundle

A PHP image serving framework.

The main goal is to provide a robust framework to create an "on the fly" image thumbnailer generator similar to [imagecache](https://www.drupal.org/project/imagecache) / [image style](https://www.drupal.org/docs/8/core/modules/image/working-with-images) in [Drupal](https://www.drupal.org/).

You can also use it to build a singlepoint multipurpose proxy server on top of a "complex" / legacy(ish) / not-yet-migrated images structure.

Here is a [Symfony 4](https://symfony.com/4) bundle for [ImageStack](https://github.com/quazardous/ImageStack).

## Installation

    composer require quazardous/imagestack-bundle

## Config

see [Resources/doc/index.rst](https://github.com/quazardous/imagestack-bundle/blob/master/Resources/doc/index.rst)

## Usage

The above config will let you have a `./images/` private folder hold original images and serves them from `images/...`.

It defines some thumbnail rules and activates images optimizers.

Say you need to display `./images/foo/cool_image.jpg` with thumbnail style.

Just hit `images/style/thumb/foo/cool_image.jpg` and voilà !

Behind the curtain, Imagestack we generate and optimize `images/style/thumb/foo/cool_image.jpg`, store it in `./public/images/style/thumb/foo/cool_image.jpg` and serve it to your browser.

So next HTTP call will be statically serverd.

## Twig

Imagestack has a Twig filter and function `imagestack`.

```html.twig
...
<img src="{{ 'foo/cool_image.jpg'|imagestack('style/thumb') }}"/>
...
```

## Changelog

  - 1.3: hello Github
  - 1.0: hello SF4

