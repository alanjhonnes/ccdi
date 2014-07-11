<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Sonata', __DIR__);

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
