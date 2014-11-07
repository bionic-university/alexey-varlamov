<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$vendorDir = dirname(dirname(__FILE__)).'/vendor/';
require_once $vendorDir.'autoload.php';

use Psr\Autoloader;
use Symfony\Component\Console\Application;

Autoloader::init();
$console = new Application();
$console->run();