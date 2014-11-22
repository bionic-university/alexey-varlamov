<?php
/**
 * Class Block for rendering response
 */

namespace Vav\CashTarget\Block;

class Goal
{
    /**
     * @var string
     */
    private $header;

    /**
     * @var string
     */
    private $message;

    public function renderView()
    {
        require dirname(__DIR__).'/template/goal/goal.phtml';
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
} 