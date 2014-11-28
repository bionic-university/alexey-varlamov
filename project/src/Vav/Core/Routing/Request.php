<?php
/**
 * Abstract class Request
 *
 * Handle request depending on different interface types
 */
namespace Vav\Core\Routing;

use Vav\Core\Routing\Request\Shell\RequestHandler as Shell;
use Vav\Core\Routing\Request\Http\RequestHandler as Http;

abstract class Request
{
    /**
     * @return Http|Shell
     */
    public static function getRequestType()
    {
        $requestType = null;
        if (php_sapi_name() === 'cli')
        {
            $requestType = new Shell();
        } else {
            $requestType = new Http();
        }

        return $requestType;
    }

    /**
     * Get request params
     *
     * @return array
     */
    abstract public function getParams();

    /**
     * Retrieve specific parameter from request
     *
     * @param $name
     * @return string
     */
    abstract public function getParam($name);

    /**
     * Retrieve current controller
     *
     * @return string
     */
    abstract public function getController();

    /**
     * Retrieve requested action
     *
     * @return string
     */
    abstract public function getAction();
}