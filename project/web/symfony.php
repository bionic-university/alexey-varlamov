<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config.php';

$appRoot= dirname(__DIR__).DS.'src'.DS;
$vendorDir = dirname(__DIR__).DS.'vendor'.DS;
set_include_path(get_include_path().PS.$appRoot);

require_once $vendorDir.'autoload.php';
Psr\Autoloader::init();

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Vav\Console\Command\SimpleCommand;

$app = new Application();
$command = new SimpleCommand();
$app->add($command);
$app->setDefaultCommand($command->getName());
$app->run();