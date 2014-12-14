<?php
namespace Vav\Core\Routing\Request;

use Vav\Core\Routing\Request;

abstract class Http extends Request
{
    /**
     * {@inheritdoc}
     */
    public function getParams()
    {

    }

    /**
     * Define new param
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }
} 