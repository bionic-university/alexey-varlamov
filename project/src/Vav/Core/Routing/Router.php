<?php
namespace Vav\Core\Routing;

use Vav\CashTarget\Vav;
use Vav\Core\Routing\Request;

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

    /**
     * Call appropriate controller, action
     *
     * @throws \Exception
     * @throws \HttpRequestException
     */
    public function process()
    {
        try {
            $controllerClass = 'Vav\\CashTarget\\Controller\\' . ucfirst($this->request->getController()) . 'Controller';
            $action = $this->request->getAction() . 'Action';
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass($this->request);
                if (is_callable(array($controller, $action))) {
                    //                call_user_func_array(array($controller, $action), $this->request->getParams());
                    $controller->$action();
                } else {
                    throw new \Exception('Method "' . $this->request->getAction() . '" does not exists.');
                }
            } else {
                throw new \HttpRequestException('Invalid controller name.');
            }
        } catch (\Exception $e) {
            Vav::log($e->getMessage());
        }
    }
}