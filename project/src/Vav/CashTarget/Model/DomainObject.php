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

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public static function collection($type)
    {
        return array();
    }

    public function getCollection()
    {
//        return self::collection(get_class($this));
        return new \ArrayObject($this);
    }

    /**
     * Define data for the object
     *
     * @param array $data
     * @return $this
     * @throws \Exception
     */
    public function setData(array $data)
    {
        if (!is_array($data)) {
            throw new \Exception('This method requires an array as a parameter, a string given.');
        }
        foreach ($data as $key => $value) {
            if (is_null($value) || $value == '') {
                continue;
            }

            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                call_user_func(array($this, $method), $value);
            } else {
                throw new \BadMethodCallException('Method: "'.$method.'". Does not exists.');
            }
        }

        return $this;
    }
}