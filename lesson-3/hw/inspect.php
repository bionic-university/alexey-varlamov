<?php
// set error mode
error_reporting(E_ALL);
ini_set('display_errors', 1);

// define include path
$pwd = PATH_SEPARATOR.__DIR__.PATH_SEPARATOR.__DIR__.DIRECTORY_SEPARATOR.'app';
set_include_path(get_include_path().$pwd);

// include class autoloader
require('lib'.DIRECTORY_SEPARATOR.'Pcr-4'.DIRECTORY_SEPARATOR.'Autoloader.php');
Pcr\Autoloader::init();

// namespaces
use Shell\DriverScript;
use Shell\ShellException;
use Vav\Vehicle\VehicleException;
use Vav\Driver\DriverException;

try {
    $driverScript = new DriverScript();
    $result = $driverScript->execute();
    echo PHP_EOL . implode(PHP_EOL, $result) . PHP_EOL . PHP_EOL;
} catch (ShellException $e) {
    echo $e->getMessage() . PHP_EOL;
} catch (VehicleException $e) {
    echo $e->getMessage() . PHP_EOL;
} catch (DriverException $e) {
    echo $e->getMessage() . PHP_EOL;
} catch (Exception $e) {
    echo $e->__toString() . PHP_EOL;
}