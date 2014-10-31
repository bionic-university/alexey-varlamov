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
use \Vav\Vehicle;
use \Vav\Driver;
use \Vav\Inspector;

$categories = ['c', 'b'];
$transport  = ['truck', 'car'];

$driver    = new Driver();
$inspector = new Inspector();

$driver->setDrivingLicense($categories);

//$trans = '';
foreach ($transport as $trans) {
    switch(strtolower(trim($trans))) {
        case 'moto':
        case 'motorcycle':
        case 'moped':
        case 'bike':
            $driver->attach(new \Vav\Vehicle\Motorcycle());
            break;
        case 'car':
        case 'auto':
        case 'autocar':
        case 'automobile':
        case 'machine':
            $driver->attach(new \Vav\Vehicle\Car());
            break;
        case 'truck':
        case 'lorry':
            $driver->attach(new \Vav\Vehicle\Truck());
            break;
        case 'bus':
        case 'autobus':
            $driver->attach(new \Vav\Vehicle\Bus());
            break;
        case 'tram':
        case 'trolley':
        case 'streetcar':
            $driver->attach(new \Vav\Vehicle\Trams());
            break;
        default:
            throw new Exception('Unknown transport. Please specify another kind of transport.');
            break;
    }
}

$result = [];
foreach ($driver->getDrivingLicense() as $category) {
    $result[] = $inspector->check($driver->getGarage(), $category);
}

while ($driver->getGarage()->valid()) {
    $result[] = 'You cannot drive '.$driver->getGarage()->current()->getType().'. Boost your skills.';
    $driver->getGarage()->next();
}

echo implode(PHP_EOL, $result).PHP_EOL;