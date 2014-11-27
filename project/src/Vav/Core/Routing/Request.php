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

    abstract public function getParams();
    abstract public function getParam($name);
    abstract public function getController();
    abstract public function getAction();
}