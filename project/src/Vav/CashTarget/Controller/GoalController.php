<?php
/**
 * Class GoalController
 *
 * Define actions with cash targets
 */

namespace Vav\CashTarget\Controller;


class GoalController
{
    public function indexAction()
    {

    }

    public function getAction(...$params)
    {
        echo PHP_EOL;
        print_r($params);
        echo PHP_EOL;
        die();
    }
} 