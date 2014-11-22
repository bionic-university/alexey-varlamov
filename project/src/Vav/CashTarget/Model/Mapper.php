<?php

namespace Vav\CashTarget\Model;

use Vav\CashTarget\Vav;

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
    
    abstract protected function update(DomainObject $obj);

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
}