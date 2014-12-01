<?php
/**
 * Class Block for rendering response
 */

namespace Vav\CashTarget\Block;

use Vav\CashTarget\Model\Mapper\Collection;

class Goal
{
    /**
     * @var Collection
     */
    private $goal;

    public function __construct()
    {
    }

    /**
     * @var string
     */
    private $header;

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
                $template = '/template/goal/main.phtml';
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
} 