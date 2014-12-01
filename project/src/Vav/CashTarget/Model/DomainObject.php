<?php

namespace Vav\CashTarget\Model;

use Vav\CashTarget\Helper\CollectionFactory;

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

    /**
     * Delegate creating of DomainObject collection to {@link CollectionFactory::getCollection()}
     *
     * @see CollectionFactory::getCollection()
     * @param $type
     * @return Mapper\Collection
     */
    private static function collection($type)
    {
        return CollectionFactory::getCollection($type);
    }

    /**
     * Return collection of DomainObject depending on current class
     *
     * @return Mapper\Collection
     */
    public function getCollection()
    {
        return self::collection(get_class($this));
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
            
            $keys = explode('_', $key);
            $keys = array_map('ucfirst', $keys);
            $key  = implode('', $keys);

            $method = 'set' . $key;
            if (method_exists($this, $method)) {
                call_user_func(array($this, $method), $value);
            } else {
                throw new \BadMethodCallException('Method: "' . $method . '". Does not exists.');
            }
        }

        return $this;
    }
}