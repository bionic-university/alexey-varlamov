<?php
namespace Vav;

use Vav\Vehicle\Bus;
use Vav\Vehicle\Car;
use Vav\Vehicle\Motorcycle;
use Vav\Vehicle\Truck;
use Vav\Vehicle\Trams;
use Vav\Vehicle\VehicleException;

/**
 * Class Vehicle for storing info about transport
 *
 * @author Alexey Varlamov <l.e.h.a.vav@gmail.com>
 * @version 1.0
 */
abstract class Vehicle
{
    protected $category = [];
    protected $type = [];

    /**
     * @param $type
     * @return null|Bus|Car|Motorcycle|Trams|Truck
     * @throws VehicleException
     */
    public static function getVehicleInstance($type)
    {
        $vehicle = null;
        switch(strtolower($type)) {
            case 'moto':
            case 'motorcycle':
            case 'moped':
            case 'bike':
                $vehicle = new Motorcycle();
                break;
            case 'car':
            case 'auto':
            case 'autocar':
            case 'automobile':
            case 'machine':
                $vehicle = new Car();
                break;
            case 'truck':
            case 'lorry':
                $vehicle = new Truck();
                break;
            case 'bus':
            case 'autobus':
                $vehicle = new Bus();
                break;
            case 'tram':
            case 'trolley':
            case 'streetcar':
                $vehicle = new Trams();
                break;
            default:
                throw new VehicleException('Unknown transport. Please specify another kind of transport.');
                break;
        }

        return $vehicle;
    }

    /**
     * @return array
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return array
     */
    public function getType()
    {
        return $this->type;
    }
} 