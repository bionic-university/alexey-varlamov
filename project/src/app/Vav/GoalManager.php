<?php
/**
 * Class for managing financial goals
 */

namespace Vav;


class GoalManager {
    private $id;
    private $title;

    public function __construct($title)
    {
        $this->id = 1;
        $this->title = $title;
    }

    /**
     * @return int
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

    public function addGoal()
    {
        $arr = [$this->id, $this->title];
        $fileObject = new \SplFileObject('goals.csv', 'w');
        $fileObject->fputcsv($arr, ',', '"');
    }

} 