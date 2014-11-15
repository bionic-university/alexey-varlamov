<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$pwd = PATH_SEPARATOR.__DIR__.PATH_SEPARATOR.__DIR__.DIRECTORY_SEPARATOR.'app';
set_include_path(get_include_path().$pwd);

$vendorDir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR;
require_once $vendorDir.'autoload.php';

use Psr\Autoloader;
use Shell\ShellRequestHandler;
//use Symfony\Component\Console\Application;
//use Symfony\Component\Console\Input\InputInterface;
//use Symfony\Component\Console\Input\InputArgument;
//use Symfony\Component\Console\Input\InputOption;
//use Symfony\Component\Console\Output\OutputInterface;
//$console = new Application();
//$console->run();

Autoloader::init();
$request = new ShellRequestHandler();
$request->execute();