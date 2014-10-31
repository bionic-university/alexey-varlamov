<?php
namespace Vav;

/**
 * Class Vehicle for storing info about transport
 *
 * @author Alexey Varlamov <l.e.h.a.vav@gmail.com>
 * @version 1.0
 */
abstract class Vehicle
{
    protected $category;
    protected $type;

    public function getCategory()
    {
        return $this->category;
    }

    public function getType()
    {
        return $this->type;
    }
} 