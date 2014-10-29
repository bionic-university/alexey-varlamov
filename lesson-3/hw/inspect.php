<?php
// set error mode
error_reporting(E_ALL);
ini_set('display_errors', 1);

// define include path
$pwd = getcwd().DIRECTORY_SEPARATOR.dirname($_SERVER['SCRIPT_NAME']);
set_include_path(get_include_path().PATH_SEPARATOR.$pwd.PATH_SEPARATOR.$pwd.DIRECTORY_SEPARATOR."app");

// include class autoloader
require 'lib'.DIRECTORY_SEPARATOR.'Pcr-4'.DIRECTORY_SEPARATOR.'Autoloader.php';
Pcr\Autoloader::init();

// namespaces
//use Shell\CsvScriptParser;
//use Shell\ShellException;
use \Vav\Vehicle;
Vehicle::match();