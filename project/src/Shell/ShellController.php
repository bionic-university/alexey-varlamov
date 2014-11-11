<?php
namespace Shell;

use Vav\GoalManager;
use Vav\Executable;

class ShellController extends AbstractShell implements Executable
{
    public function execute()
    {
        $this->validateArgs();
        $this->handleRequest();
        $goal = new GoalManager($this->getArg('g'));
        $goal->addGoal();

//        return $result;
    }

    private function handleRequest()
    {

    }

    /**
     * @return bool
     * @throws ShellException
     */
    private function validateArgs()
    {
        /*if (is_bool($this->getArg('t'))) {
            throw new ShellException('Please specify transport(ex. -t car,bike,tram).');
        }
        if (is_bool($this->getArg('c'))) {
            throw new ShellException('Please specify driving category(ex. -c A,B,C).');
        }*/

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