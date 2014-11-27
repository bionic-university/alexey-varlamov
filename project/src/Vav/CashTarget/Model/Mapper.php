<?php

namespace Vav\CashTarget\Model;

use Vav\CashTarget\Vav;
use Vav\CashTarget\Model\Mapper\Collection;

abstract class Mapper
{
    /**
     * @var \PDO
     */
    protected static $PDO;

    public function __construct()
    {
        if (!isset(self::$PDO)) {
            try {
                self::$PDO = new \PDO(DSN, USER, PWD);
                self::$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$PDO->exec('SET NAMES utf8');
            } catch (\PDOException $e) {
                Vav::log('Error: ' . $e->getMessage());
            }
        }
        $this->initStatements();
    }

    /**
     * @param integer $id
     * @return DomainObject | \Vav\CashTarget\Model\Domain\Goal
     */
    public function load($id)
    {
        $array = [];
        try {
            $this->selectStmt()->bindParam('id', $id, \PDO::PARAM_INT);
            $this->selectStmt()->execute();
            $this->selectStmt()->setFetchMode(\PDO::FETCH_ASSOC);
            $array = $this->selectStmt()->fetch();
            $this->selectStmt()->closeCursor();
        } catch (\PDOException $e) {
            Vav::log('Error: '.$e->getMessage());
        }
        if (!is_array($array) || !isset($array['id'])) {
            return null;
        }
        $object = $this->createObject($array);

        return $object;
    }

    /**
     * @param $array
     * @return DomainObject
     */
    public function createObject($array)
    {
        return $this->doCreateObject($array);
    }

    public function insert(DomainObject $obj)
    {
        $this->doInsert($obj);
    }

    public function update(DomainObject $obj)
    {
        $this->doUpdate($obj);
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        $this->selectAllStmt()->execute();
        return $this->createCollection(
            $this->selectAllStmt()->fetchAll(\PDO::FETCH_ASSOC)
        );
    }

    /**
     * @param DomainObject $obj
     * @return string
     */
    public function prepareFields(DomainObject $obj)
    {
        return implode('`, `', array_keys(get_object_vars($obj)));
    }

    /**
     * @param DomainObject $obj
     * @return string
     */
    public function prepareValues(DomainObject $obj)
    {
        $values = array_map(
          function ($el) {
              return '"' . $el . '"';
          },
          get_object_vars($obj)
        );
        $values = implode(',', $values);

        return $values;
    }
    
    abstract protected function doUpdate(DomainObject $obj);

    abstract protected function doInsert(DomainObject $obj);

    /**
     * @param array $array
     * @return DomainObject
     */
    abstract protected function doCreateObject(array $array);

    abstract protected function initStatements();

    /**
     * @return \PDOStatement
     */
    abstract protected function selectStmt();

    /**
     * @return \PDOStatement
     */
    abstract protected function selectAllStmt();

    /**
     * @param array $raw
     * @return Collection
     */
    abstract public function createCollection(array $raw);
}