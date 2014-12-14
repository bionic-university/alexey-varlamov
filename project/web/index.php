<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$environment = 'dev';

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config.php';

//$appRoot= dirname(__DIR__).DS.'src'.DS;
//set_include_path(get_include_path().PS.$appRoot);
$vendorDir = dirname(__DIR__).DS.'vendor'.DS;
require_once $vendorDir.'autoload.php';

$whoops = new Whoops\Run();
if ($environment !== 'production') {
    $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
} else {
    $whoops->pushHandler(function ($e) {
        echo 'Friendly error page and send an email to the developer.';
    });
}
//$whoops->register();

use Vav\Core\Routing\Router;

$router = new Router();
$router->process();