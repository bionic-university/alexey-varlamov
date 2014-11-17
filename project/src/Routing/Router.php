<?php
namespace Routing;

use Routing\Request;

class Router
{
    /**
     * @var Request;
     */
    private $request;

    /**
     * Get request type object
     */
    public function __construct(){
        $this->request = Request::getRequestType();
    }

    public function process()
    {
        $controllerClass = 'Vav\\CashTarget\\Controller\\'.ucfirst($this->request->getController()).'Controller';
        $action          = $this->request->getAction().'Action';
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass;
            if (is_callable(array($controller, $action))) {
//                call_user_func_array(array($controller, $action), $this->request->getParams());
                $controller->$action();
            } else {
                throw new \Exception('Method "' . $action . '" does not exists.');
            }
        } else {
            throw new \HttpRequestException('Invalid controller name.');
        }
    }
}