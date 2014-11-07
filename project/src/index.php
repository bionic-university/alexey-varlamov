<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$vendorDir = dirname(dirname(__FILE__)).'/vendor/';
$loader = require_once $vendorDir.'autoload.php';
//require_once 'lib/Pcr-4/Autoloader.php';
$loader->add('Pcr\\', 'lib/Pcr-4');

/*$loader = require 'vendor/autoload.php';
$loader->add('Symfony\\', 'vendor/symfony/console/Symfony');*/
//use Pcr\Autoloader;
use Symfony\Component\Console\Application;

Pcr\Autoloader::init();
$console = new Application();
$console->run();

/*require 'lib/Pcr-4/Autoloader.php';
Pcr\Autoloader::init();*/