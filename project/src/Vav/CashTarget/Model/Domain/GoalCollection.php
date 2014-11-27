<?php
/**
 * Created by PhpStorm.
 * User: vav
 * Date: 23.11.14
 * Time: 19:57
 */

namespace Vav\CashTarget\Model\Domain;


use Vav\CashTarget\Model\DomainObject;

interface GoalCollection
{
    /**
     * @param DomainObject $goal
     * @return mixed
     */
    public function add(DomainObject $goal);
}