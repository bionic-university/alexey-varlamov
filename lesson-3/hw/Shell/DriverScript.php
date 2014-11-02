<?php
namespace Shell;

use Vav\Driver;
use Vav\Inspector;
use Vav\Executable;
use Vav\Vehicle;
use Vav\Vehicle\VehicleException;

class DriverScript extends AbstractShell implements Executable
{
    /**
     * @var array
     */
    private $transport = array();
    /**
     * @var array
     */
    private $categories = array();
    /**
     * @var Driver
     */
    private $driver;
    /**
     * @var Inspector
     */
    private $inspector;

    public function execute()
    {
        $this->validateArgs();
        $this->driver    = new Driver();
        $this->inspector = new Inspector();
        $this->driver->setDrivingLicense($this->categories);
        $this->setGarage();
        $result = $this->inspect();

        return $result;
    }

    /**
     * @throws VehicleException
     */
    private function setGarage()
    {
        foreach ($this->transport as $trans) {
            $this->driver->attach(Vehicle::getVehicleInstance($trans));
        }
    }

    /**
     * @return array
     */
    private function inspect()
    {
        $result = [];
        foreach ($this->driver->getDrivingLicense() as $category) {
            $result[] = $this->inspector->check($this->driver->getGarage(), $category);
        }

        $this->driver->getGarage()->rewind();
        while ($this->driver->getGarage()->valid()) {
            $result[] = 'You cannot drive ' . $this->driver->getGarage()->current()->getType() . '. Boost your skills.';
            $this->driver->getGarage()->next();
        }
        $result = array_diff($result, array(''));

        return $result;
    }

    /**
     * @return bool
     * @throws ShellException
     */
    private function validateArgs()
    {
        if (is_bool($this->getArg('t'))) {
            throw new ShellException('Please specify transport(ex. -t car,bike,tram).');
        }
        if (is_bool($this->getArg('c'))) {
            throw new ShellException('Please specify driving category(ex. -c A,B,C).');
        }

        $this->transport  = explode(',', $this->getArg('t'));
        $this->categories = explode(',', $this->getArg('c'));

        return true;
    }

    /**
     * Show help
     */
    public function showHelp()
    {
        return <<<HELP
CSV Parser
------------------
Usage: php inspect.php --[options]

-t          transport(comma-separated): bike,car,truck,bus,tram
-c          driving category(comma-separate): A,B,C,D,F
--help(h)   this help


HELP;
    }
}