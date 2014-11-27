<?php
namespace Vav\CashTarget\Model\Mapper\Collection;

use Vav\CashTarget\Model\Domain\GoalCollection;
use Vav\CashTarget\Model\Mapper\Collection;

class Goal extends Collection implements GoalCollection
{
    /**
     * @return string
     */
    public function targetClass()
    {
        return 'Vav\CashTarget\Model\Domain\Goal';
    }
} 