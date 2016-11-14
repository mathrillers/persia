<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';
//$loader->add('Knp', __DIR__.'/../vendor/knplabs/knp-snappy-bundle');
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
