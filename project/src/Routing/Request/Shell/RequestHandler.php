<?php
namespace Routing\Request\Shell;

use Vav\CashTarget\Controller\Executable;
use Routing\Request\Shell;

class RequestHandler extends Shell implements Executable
{
    /**
     * @var string $controller - current controller name
     */
    private $controller = 'goal';

    /**
     * @var string $action - current action name
     */
    private $action;

    /**
     *
     */
    public function execute()
    {

    }

    /**
     * Prepare input params - determine command and params
     */
    protected function prepareParams()
    {
        $current = null;
        foreach ($_SERVER['argv'] as $arg) {
            if ($arg === 'index.php') {
                continue;
            }

            $match = array();
            if (preg_match('/^--([\w\d,]+)$/i', $arg, $match) ||
                preg_match('/^-([\w\d,]+)$/i', $arg, $match)
            ) {
                $this->action = $match[1];
                $current = $match[1];
//                $this->args[$current] = true;
            } else {
                if (preg_match('/([\w\d]+)=([\w\d]+)/i', $arg, $match)) {
                    $this->args[$match[1]] = $match[2];
                } elseif ($current) {
                    $this->args[$current] = $arg;
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return bool
     */
    protected function validate()
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
    protected function showHelp()
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