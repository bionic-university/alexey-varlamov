<?php
namespace Vav\CashTarget\Model\Mapper;


use Vav\CashTarget\Model\DomainObject;
use Vav\CashTarget\Model\Mapper;

abstract class Collection implements \Iterator
{
    /**
     * @var \Vav\CashTarget\Model\Mapper
     */
    private $mapper;

    /**
     * @var int
     */
    private $total = 0;

    /**
     * @var array
     */
    private $raw = array();

    /**
     * @var
     */
    private $result;

    /**
     * @var int
     */
    private $pointer = 0;

    /**
     * @var array
     */
    private $objects = array();

    /**
     * @param array $raw
     * @param Mapper $mapper
     */
    public function __construct(array $raw = null, Mapper $mapper = null)
    {
        if (!is_null($raw) && !is_null($mapper)) {
            $this->raw = $raw;
            $this->total = count($raw);
        }
        $this->mapper = $mapper;
    }

    /**
     * @param DomainObject $object
     * @throws \Exception
     */
    public function add(DomainObject $object)
    {
        $class = $this->targetClass();
        if (! $object instanceof $class) {
            throw new \Exception('This is a "'.$class.'" collection.');
        }
        $this->objects[$this->total] = $object;
        $this->total++;
    }

    /**
     * @param int $num
     * @return DomainObject
     */
    private function getRaw($num)
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }
        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }
        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->mapper->createObject($this->raw[$num]);
            return $this->objects[$num];
        }
    }

    public function getData()
    {
        return $this->raw;
    }

    /**
     * Reset array pointer
     */
    public function rewind()
    {
        $this->pointer = 0;
    }

    /**
     * @return DomainObject
     */
    public function current()
    {
        return $this->getRaw($this->pointer);
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->pointer;
    }

    /**
     * @return DomainObject
     */
    public function next()
    {
        $raw = $this->getRaw($this->pointer);
        if ($raw) {
            $this->pointer++;
        }

        return $raw;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return (!is_null($this->current()));
    }

    /**
     * @return string
     */
    abstract public function targetClass();
} 