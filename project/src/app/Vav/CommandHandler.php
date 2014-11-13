<?php
/**
 * Handle command from console
 */

namespace Vav;


use Vav\Goal\GoalManager;
use Vav\Goal;

class CommandHandler
{
    private $defaultCmd = 'get';
    private $cmd;
    private $goal;
    private $goalManager;

    private function __construct()
    {
        $this->goalManager = new GoalManager();
        $this->goal = new Goal();
    }

    public function handle($params)
    {

    }

    private function save()
    {

    }

    private function load()
    {

    }

    private function show()
    {

    }
} 