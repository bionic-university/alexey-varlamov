<?php
namespace Vav\Core\Routing\Request\Http;

use Vav\Core\Routing\Request\Http;

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

    public function getParam($name)
    {
        return '';
    }
}