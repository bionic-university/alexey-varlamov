<?php
namespace Vav\Core\Routing\Request\Shell;

use Vav\Core\Routing\Request\Shell;

class RequestHandler extends Shell
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @var string $controller - current controller name
     */
    private $controller = 'goal';

    /**
     * @var string $action - current action name
     */
    private $action = 'index';

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
//                $this->params[$current] = true;
            } else {
                if (preg_match('/([\w\d]+)=([\w\d]+)/i', $arg, $match)) {
                    $this->params[$match[1]] = $match[2];
                } elseif ($current) {
                    $this->params[$arg] = true;
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
    public function showHelp()
    {
        return <<<HELP
Cash Target
------------------
Usage: php inspect.php --[options]

--get           show goal: <id>, all
--set           define new goal, set goal params after this command: --price 120 --name notebook
--price         set goal price
--name          set goal title
--deadline      set due date: 5d/w/m/y
--priority      set priority of the goal, 1 is a higher: priority=1, priority=10
--fsum          set the amount of funding: 120
--fperiod       set the interval of funding: d/w/m/y
--auto          set auto funding by fperiod param: true/false
--load          load specific goal and change its params, by calling the above commands: <id> --name car
--report        show goal report: <id>, all
--optimize      show optimal funding: <id>

--help(h)       this help


HELP;
    }
}