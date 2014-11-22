<?php

namespace Vav\CashTarget\Model\Mapper;

use Vav\CashTarget\Model\Domain\Goal;
use Vav\CashTarget\Model\DomainObject;
use Vav\CashTarget\Model\Mapper;

class GoalMapper extends Mapper
{
    /**
     * @var \PDOStatement;
     */
    private $selectStmt;
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
        $this->selectStmt = self::$PDO->prepare('SELECT * FROM goal WHERE id = :id');
        $this->updateStmt = self::$PDO->prepare('UPDATE goal SET name=?, price=? WHERE id=?');
        $this->insertStmt = self::$PDO->prepare('INSERT INTO goal (name, price) VALUES(?, ?)');
    }

    public function getCollection(array $raw)
    {
        return new GoalCollection($raw, $this);
    }

    protected function update(DomainObject $obj) {
        $values = array($obj->getName(), $obj->getId());
        $this->updateStmt->execute($values);
    }

    protected function doInsert(DomainObject $obj)
    {
        $this->insertStmt->bindParam(1, $obj->getName(), \PDO::PARAM_STR);
        $this->insertStmt->bindParam(2, $obj->getPrice(), \PDO::PARAM_STR);
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
        $goal->setName($array['name']);
        $goal->setPrice($array['price']);

        return $goal;
    }

    /**
     * @return \PDOStatement
     */
    protected function selectStmt() {
        return $this->selectStmt;
    }
}