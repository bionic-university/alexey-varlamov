<?php

namespace Vav\CashTarget\Model;

use Vav\CashTarget\Vav;
use Vav\CashTarget\Model\Mapper\Collection;
use Vav\Core\Connector\PdoConnector;

abstract class Mapper
{
    /**
     * @var \PDO
     */
    protected static $PDO;

    /**
     * Instantiate PDO
     */
    public function __construct()
    {
        if (!isset(self::$PDO)) {
            self::$PDO = PdoConnector::getConnector();
            self::$PDO->query('use ' . DB_NAME);
        }
        $this->initStatements();
    }

    /**
     * Get entity model by id
     *
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

    /**
     * Perform SQL insert statement
     *
     * @param DomainObject $obj
     */
    public function insert(DomainObject $obj)
    {
        $this->doInsert($obj);
    }

    /**
     * Perform SQL update statement
     *
     * @param DomainObject $obj
     */
    public function update(DomainObject $obj)
    {
        $this->doUpdate($obj);
    }

    /**Perform SQL delete statement
     *
     * @param  int  $id - id of goal which must be deleted
     * @param  bool $isDeleteAll - delete all records or not
     * @return bool
     */
    public function delete($id = null, $isDeleteAll = false)
    {
        if ($isDeleteAll) {
            $this->deleteAllStmt();
            $this->deleteAllStmt()->execute();
        } else {
            $this->deleteStmt()->bindParam(':id', $id, \PDO::PARAM_INT);
            $this->deleteStmt()->execute();
        }

        return true;
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
     * Prepare table fields for SQL statements
     *
     * @param DomainObject $obj
     * @param bool $isUpdate
     * @return string
     */
    public function prepareFields(DomainObject $obj, $isUpdate = false)
    {
        $fields = array_keys(get_object_vars($obj));
        foreach ($fields as &$field) {
            $field = preg_split('/(?=[A-Z])/', $field);
            if (is_array($field)) {
                $field = array_map('strtolower', $field);
                $field = implode('_', $field);
            }
            if ($isUpdate) {
                $field = $field . ' = :' . $field;
            }
        }

        return implode(',', $fields);
    }

    /**
     * Prepare table values for SQL statements
     *
     * @param DomainObject $obj
     * @param bool $isUpdate
     * @return string
     */
    public function prepareValues(DomainObject $obj, $isUpdate = false)
    {
        $values = array_map(
          function ($ind, $el) use ($isUpdate) {
              return ($isUpdate) ? $el : '"' . $el . '"';
          },
          array_keys(get_object_vars($obj)),
          array_values(get_object_vars($obj))
        );
        $values = implode(',', $values);
        $values = str_replace('""', 'null', $values);

        return $values;
    }

    /**
     * @return \PDOStatement
     */
    abstract protected function deleteStmt();

    /**
     * @return \PDOStatement
     */
    abstract protected function deleteAllStmt();

    /**
     * @param DomainObject $obj
     */
    abstract protected function doUpdate(DomainObject $obj);

    /**
     * @param DomainObject $obj
     */
    abstract protected function doInsert(DomainObject $obj);

    /**
     * @param array $array
     * @return DomainObject
     */
    abstract protected function doCreateObject(array $array);

    /**
     * Initialize SQL statements
     */
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
     */
    abstract protected function createCollection(array $raw);
}