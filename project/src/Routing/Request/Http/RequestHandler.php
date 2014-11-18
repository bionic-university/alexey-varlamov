<?php
namespace Routing\Request\Http;

use Routing\Request\Http;

class RequestHandler extends Http
{
    /**
     * @var string $controller - current controller name
     */
    private $controller = 'goal';

    /**
     * @var string $action - current action name
     */
    private $action = 'index';

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }


}