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

--get           show goal: <id>, all
--set           define new goal, set goal params after this command: --price 120 --name notebook
--price         set goal price
--name          set goal title
--deadline      set due date: 5d/w/m/y
--fsum          set the amount of funding: 120
--fperiod       set the interval of funding: d/w/m/y
--load          load specific goal and change its params, by calling the above commands: <id> --name car
--auto          set auto funding by fperiod param: true/false
--report        show goal report: <id>, all
--optimize      show optimal funding: <id>

--help(h)       this help


HELP;
    }
}