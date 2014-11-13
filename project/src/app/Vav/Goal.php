<?php
/**
 * Class Goal
 */

namespace Vav;


class Goal
{
    private $title;
    private $price;
    private $deadline;
    private $fPeriod;
    private $fSum;
    private $isAutoFunding;

    public function __construct()
    {

    }

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
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


} 