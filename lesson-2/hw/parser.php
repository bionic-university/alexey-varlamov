<?php
// set error mode
error_reporting(E_ALL);
ini_set('display_errors', 1);

// define include path
$pwd = getcwd();
set_include_path(get_include_path().PATH_SEPARATOR.$pwd.PATH_SEPARATOR.$pwd.DIRECTORY_SEPARATOR."app");

// include class autoloader
require_once('lib' . DIRECTORY_SEPARATOR . 'Autoloader.php');
Autoloader::init();

// namespaces
use Shell\CsvScriptParser;
use Shell\ShellException;
use Vav\Parser\ParserException;

// parse csv
try {
    $csvParser = new CsvScriptParser;
    $parsedCsv = $csvParser->execute();
    print_r($parsedCsv);
} catch (ParserException $e) {
    echo $e->getMessage();
} catch (ShellException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->__toString();
}