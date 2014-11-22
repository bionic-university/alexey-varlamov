<?php
/**
 * Class Goal
 */

namespace Vav\CashTarget\Model\Domain;

use Vav\CashTarget\Model\DomainObject;

class Goal extends DomainObject
{
    private $name;
    private $price;
    private $deadline;
    private $fPeriod;
    private $fSum;
    private $isAutoFunding;

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
        return $this->fPeriod;
    }

    /**
     * @param mixed $fPeriod
     */
    public function setFPeriod($fPeriod)
    {
        $this->fPeriod = $fPeriod;
    }

    /**
     * @return mixed
     */
    public function getFSum()
    {
        return $this->fSum;
    }

    /**
     * @param mixed $fSum
     */
    public function setFSum($fSum)
    {
        $this->fSum = $fSum;
    }

    /**
     * @return mixed
     */
    public function getIsAutoFunding()
    {
        return $this->isAutoFunding;
    }

    /**
     * @param mixed $isAutoFunding
     */
    public function setIsAutoFunding($isAutoFunding)
    {
        $this->isAutoFunding = $isAutoFunding;
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
} 