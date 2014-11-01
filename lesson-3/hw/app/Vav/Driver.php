<?php
namespace Vav;

use Vav\Driver\DriverException;

/**
 * Class Driver
 */
class Driver {
    /**
     * @var \SplObjectStorage
     */
    private $garage;
    /**
     * @var
     */
    private $drivingLicense;

    /**
     * Initialize \SplObjectStorage
     */
    public function __construct()
    {
        $this->garage = new \SplObjectStorage;
    }

    /**
     * @param Vehicle $obj
     */
    public function attach(Vehicle $obj)
    {
        $this->garage->attach($obj);
    }

    /**
     * @param Vehicle $obj
     */
    public function detach(Vehicle $obj)
    {
        $this->garage->detach($obj);
    }

    /**
     * @return \SplObjectStorage
     */
    public function getGarage()
    {
        return $this->garage;
    }

    /**
     * @return mixed
     */
    public function getDrivingLicense()
    {
        return $this->drivingLicense;
    }

    /**
     * @param mixed $drivingLicense
     */
    public function setDrivingLicense($drivingLicense)
    {
        $drivingLicense = array_map('strtoupper', $drivingLicense);
        $this->drivingLicense = $drivingLicense;
    }
} 