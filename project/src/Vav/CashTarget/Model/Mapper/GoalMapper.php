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

    public function __construct()
    {
        parent::__construct();
    }

    protected function initStatements()
    {
        $this->selectStmt    = self::$PDO->prepare('SELECT * FROM goal WHERE id = :id');
        $this->selectAllStmt = self::$PDO->prepare('SELECT * FROM goal');
//        $this->updateStmt    = self::$PDO->prepare('UPDATE goal SET name=:name, price=:price WHERE id=?');
        /*$this->insertStmt    = self::$PDO->prepare(
            'INSERT INTO goal (name, price, deadline, fsum, fperiod, auto)
              VALUES(:name, :price, :deadline, :fsum, :fperiod, :auto)'
        );*/
        /*$this->insertStmt    = self::$PDO->prepare(
            'INSERT INTO goal (name, price, deadline, fsum, fperiod, auto)
              VALUES(:name, :price, :deadline, :fsum, :fperiod, :auto)'
        );*/
    }

    /**
     * @param array $raw
     * @return Collection
     */
    public function createCollection(array $raw)
    {
        return new GoalCollection($raw, $this);
    }

    protected function doUpdate(DomainObject $obj)
    {
        $fields = $this->prepareFields($obj);
        $values = $this->prepareValues($obj);
        $query = '';

        foreach ($obj as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ((@end(array_keys(get_object_vars($obj))) != $key) ? ', ' : ' ');
        }
        $query .= 'WHERE `id` = :id';

        $this->updateStmt = self::$PDO->prepare('UPDATE `goal` SET ' . $query);
        foreach ($obj as $k => $v) {
            $this->updateStmt->bindValue(':' . $k, $v);
        }
        $this->updateStmt->bindValue(':id', $obj->getId());
        $this->updateStmt->execute();
    }

    protected function doInsert(DomainObject $obj)
    {
        if (!$obj instanceof Goal) {
            throw new \InvalidArgumentException('Object must be a type of class "domain\goal".');
        }

        $fields = $this->prepareFields($obj);
        $values = $this->prepareValues($obj);
        $this->insertStmt = self::$PDO->prepare('INSERT `goal` (`' . $fields . '`) VALUES (' . $values . ')');
        /*foreach ($obj as $k => $v) {
            $this->insertStmt->bindParam(':'.$k, $v, \PDO::PARAM_STR);
        }*/

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
    protected function selectStmt() {
        return $this->selectStmt;
    }

    /**
     * @return \PDOStatement
     */
    protected function selectAllStmt()
    {
        return $this->selectAllStmt;
    }
}