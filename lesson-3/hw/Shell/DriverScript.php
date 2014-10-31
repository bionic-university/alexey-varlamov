<?php
namespace Shell;

use Vav\Executable;

class DriverScript extends AbstractShell implements Executable
{
    public function execute()
    {
//        var_dump($this->getArg('v'));
        /*if (!$this->getArg('v'))
        if ($this->getArg('v')) {
            $vehicles[] = $this->getArg('v');
        } elseif ($this->getArg('c')) {
            $
        }*/
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

--help(h)   this help


HELP;
    }
}