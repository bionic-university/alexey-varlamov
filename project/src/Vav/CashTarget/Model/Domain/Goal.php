<?php
/**
 * Class Goal
 */

namespace Vav\CashTarget\Model\Domain;

use Vav\CashTarget\Model\DomainObject;

class Goal extends DomainObject
{
    public $name;
    public $price;
    public $priority;
    public $deadline;
    public $fperiod;
    public $fsum;
    public $auto;
    public $userId;

    /**
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param mixed $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * @return mixed
     */
    public function getFPeriod()
    {
        return $this->fperiod;
    }

    /**
     * @param mixed $fperiod
     */
    public function setFPeriod($fperiod)
    {
        $this->fperiod = $fperiod;
    }

    /**
     * @return mixed
     */
    public function getFSum()
    {
        return $this->fsum;
    }

    /**
     * @param mixed $fsum
     */
    public function setFSum($fsum)
    {
        $this->fsum = $fsum;
    }

    /**
     * @return int
     */
    public function getAuto()
    {
        return $this->auto;
    }

    /**
     * @param int $auto
     */
    public function setAuto($auto)
    {
        $this->auto = $auto;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @param int $id
     */
    protected function setUserId($id)
    {
        $this->userId = $id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return intval($this->userId);
    }
} 