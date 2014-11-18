<?php
/**
 * Class GoalController
 *
 * Define actions with cash targets
 */

namespace Vav\CashTarget\Controller;

use Routing\Request;

class GoalController
{
    /**
     * @object Request();
     */
    private $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }
    public function indexAction()
    {
//        $params = $this->request->getParams();
        echo PHP_EOL;
        print_r($this->request->getParams());
        echo PHP_EOL;
        die();
    }

    public function getAction()
    {

    }

    public function setAction()
    {
        
    }
} 