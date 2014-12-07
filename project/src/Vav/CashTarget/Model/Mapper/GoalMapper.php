<?php

namespace Vav\CashTarget\Model\Mapper;

use Vav\CashTarget\Model\Domain\Goal;
use Vav\CashTarget\Model\DomainObject;
use Vav\CashTarget\Model\Mapper;
use Vav\CashTarget\Model\Mapper\Collection\Goal as GoalCollection;

class GoalMapper extends Mapper
{
    /**
     * @var \PDOStatement;
     */
    private $selectStmt;

    /**
     * @var \PDOStatement;
     */
    private $selectAllStmt;

    /**
     * @var \PDOStatement;
     */
    private $updateStmt;

    /**
     * @var \PDOStatement;
     */
    private $insertStmt;

    /**
     * @var \PDOStatement;
     */
    private $deleteStmt;

    /**
     * @var \PDOStatement;
     */
    private $deleteAllStmt;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Instantiate PDOStatements
     */
    protected function initStatements()
    {
        $this->selectStmt    = self::$PDO->prepare('SELECT * FROM goal WHERE id = :id');
        $this->selectAllStmt = self::$PDO->prepare('SELECT * FROM goal');
        $this->deleteStmt    = self::$PDO->prepare('DELETE FROM goal WHERE id = :id');
        $this->deleteAllStmt = self::$PDO->prepare('DELETE FROM goal');
    }

    /**
     * @param array $raw
     * @return Collection
     */
    protected function createCollection(array $raw)
    {
        return new GoalCollection($raw, $this);
    }

    /**
     * @param DomainObject $obj
     */
    protected function doUpdate(DomainObject $obj)
    {
        $query  = '';
        $fields = $this->prepareFields($obj);
        $values = explode(',', $this->prepareValues($obj, true));
        $query .= $this->prepareFields($obj, true);
        $query .= ' WHERE id = :id';
        $this->updateStmt = self::$PDO->prepare('UPDATE `goal` SET ' . $query);
        foreach (explode(',', $fields) as $k => $v) {
            $this->updateStmt->bindValue(':' . $v, $values[$k]);
        }
        $this->updateStmt->bindValue(':id', $obj->getId());
        $this->updateStmt->execute();
    }

    /**
     * @param DomainObject $obj
     */
    protected function doInsert(DomainObject $obj)
    {
        if (!$obj instanceof Goal) {
            throw new \InvalidArgumentException('Object must be a type of class "domain\goal".');
        }

        $fields = $this->prepareFields($obj);
        $values = $this->prepareValues($obj);
        $this->insertStmt = self::$PDO->prepare('INSERT `goal` (' . $fields . ') VALUES (' . $values . ')');
        $this->insertStmt->execute();
        $id = self::$PDO->lastInsertId();
        $obj->setId($id);
    }

    /**
     * @param array $array
     * @return Goal
     */
    protected function doCreateObject(array $array) {
        $goal = new Goal($array['id']);
        $goal->setData($array);

        return $goal;
    }

    /**
     * @return \PDOStatement
     */
    protected function selectStmt()
    {
        return $this->selectStmt;
    }

    /**
     * @return \PDOStatement
     */
    protected function selectAllStmt()
    {
        return $this->selectAllStmt;
    }

    /**
     * @return \PDOStatement
     */
    protected function deleteStmt()
    {
        return $this->deleteStmt;
    }

    /**
     * @return \PDOStatement
     */
    protected function deleteAllStmt()
    {
        return $this->deleteAllStmt;
    }
}