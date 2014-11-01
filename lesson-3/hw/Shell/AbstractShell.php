<?php
namespace Shell;

abstract class AbstractShell
{
    /**
     * @var array - input arguments
     */
    private $args = array();

    abstract function showHelp();

    public function __construct()
    {
        $this->parseArgs();
        $this->_showHelp();
    }

    /**
     * Parse input arguments
     *
     * @return object $this
     */
    private function parseArgs()
    {
        $current = [];
        foreach ($_SERVER['argv'] as $arg) {
            if ($arg === 'parser.php') {
                continue;
            }

            $match = array();
            if (preg_match('/^--([\w\d,]+)$/i', $arg, $match) ||
                preg_match('/^-([\w\d,]+)$/', $arg, $match)
            ) {
                $current = $match[1];
                $this->args[$current] = true;
            } else {
                if ($current) {
                    $this->args[$current] = $arg;
                }
            }
        }

        return $this;
    }

    /**
     * Retrieve argument value by name
     *
     * @param string $name      - name of the argument
     * @return mixed $result    - argument value or false
     */
    protected function getArg($name)
    {
        $result = false;
        if (isset($this->args[$name])) {
            $result = $this->args[$name];
        }

        return $result;
    }

    /**
     * Show help if input argument is 'h' or 'help'
     */
    private function _showHelp()
    {
        if (isset($this->args['h']) || isset($this->args['help'])) {
            die($this->showHelp());
        }
    }
}