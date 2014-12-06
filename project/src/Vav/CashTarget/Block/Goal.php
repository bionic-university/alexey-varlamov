<?php
/**
 * Class Block for rendering response
 */

namespace Vav\CashTarget\Block;

use Vav\CashTarget\Model\Mapper\Collection;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\Table;

class Goal
{
    /**
     * @var Collection
     */
    private $goal;

    /**
     * @var string
     */
    private $header;

    public function __construct()
    {
    }

    /**
     * Include template file depending on type of action
     *
     * @param string $type - type of action
     */
    private $message;

    public function renderView($type = 'index')
    {
        $template = '';
        switch ($type) {
            case 'index':
            case 'get':
            case 'save':
//                $template = '/template/goal/main.phtml';
                $template = '/template/goal/dev.phtml';
                break;
            case 'report':
                $template = '/template/goal/report.phtml';
                break;
            case 'optimizer':
                $template = '/template/goal/optimizer.phtml';
                break;
        }

        require dirname(__DIR__) . $template;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param string $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param Collection $goal
     */
    public function setGoal($goal)
    {
        $this->goal = $goal;
    }

    /**
     * @return Collection
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * Show target details
     *
     * @param \Vav\CashTarget\Model\Domain\Goal $goal
     * @return string $msg
     */
    public function getDetails(\Vav\CashTarget\Model\Domain\Goal $goal)
    {
        $msg = $this->getName($goal);
        $msg .= $this->getPrice($goal);

        return $msg;
    }

    /**
     * Show target details
     *
     * @param \Vav\CashTarget\Model\Domain\Goal $goal
     * @return string $msg
     */
    public function getPrice($goal)
    {
        $msg = '';
        if ($goal->getPrice() > 0) {
            $msg = '    * Cash Target price: ' . $goal->getPrice() . PHP_EOL;
        }

        return $msg;
    }

    /**
     * Show target details
     *
     * @param \Vav\CashTarget\Model\Domain\Goal $goal
     * @return string $msg
     */
    public function getName($goal)
    {
        $msg = '';
        if ($goal->getName()) {
            $msg = '    * Cash Target name: ' . $goal->getName() . PHP_EOL;
        }

        return $msg;
    }

    public function getTable($goal)
    {
        $output = new ConsoleOutput();
        $table = new Table($output);
        $table->setHeaders(array(
            'id',
            'name',
            'price'
        ));

        $table->setRows($this->goal->getData());
        $table->render();
        
    }
} 