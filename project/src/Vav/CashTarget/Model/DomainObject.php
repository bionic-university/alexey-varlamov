<?php

namespace Vav\CashTarget\Model;

abstract class DomainObject
{
    private $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    public static function getCollection($type)
    {
        return array();
    }

    public function collection()
    {
        return self::getCollection(get_class($this));
    }
} 