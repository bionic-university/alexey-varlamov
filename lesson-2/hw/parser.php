<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// set include path
set_include_path(get_include_path().PATH_SEPARATOR.'app');

// include class autoloader
require_once('lib/Autoloader.php');
Autoloader::init();

// parse csv
$csvParser = new Shell_CsvScriptParser;
$csvParser->run();