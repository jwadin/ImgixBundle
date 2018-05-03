TacticmediaImgixBundle
=====================

Integration of the imgix library into Symfony.

Installation
-------------

The best way to install this bundle is by using [Composer](http://getcomposer.org).

For Symfony 2.x run:

``` bash
$ php composer.phar require tacticmedia/imgix-bundle ~1.0
```

For Symfony 3.4+ run:

``` bash
$ php composer.phar require tacticmedia/imgix-bundle ~2.0
```

For Symfony 4+ run:

``` bash
$ php composer.phar require tacticmedia/imgix-bundle ~3.0
```

For Symfony 4+ with PHP 7.1 run:

``` bash
$ php composer.phar require tacticmedia/imgix-bundle ~3.1
```

Then, enable the bundle:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tacticmedia\ImgixBundle\TacticmediaImgixBundle(),
    );
}
```

Finally add your sources:
```yml
tacticmedia_imgix:
    enabled: true
    default_source: folder
    sources:
        folder:
            domains:  [ acme.imgix.net ]
        proxy:
            domains:  [ acme-proxy.imgix.net ]
            sign_key: abcd1234
```

Usage
-----

In your Twig template just do:

```twig
<!-- Absolute URL with a web proxy source -->
<img src="{{ imgix('https://assets-cdn.github.com/images/modules/logos_page/Octocat.png', source='proxy', width=200, height=166) }}" width="200" height="166"/>

<!-- Absolute path with a web folder source -->
<img src="{{ imgix('images/modules/logos_page/Octocat.png', w=200, h=166) }}" width="200" />
```

You should put the `enabled` and `domains[]` setting in your parameters to be able to enable imgix for different environments.

License
-------

This bundle is released under the MIT license. See the complete license in the
bundle:

    Resources/meta/LICENSE

Credits
-------

This repository is based on https://github.com/GoldenLine/ImgixBundle which seems to be abandoned and not up-to-date with
Symfony progress.
