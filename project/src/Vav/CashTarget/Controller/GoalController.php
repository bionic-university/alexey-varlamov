<?php
/**
 * Class GoalController
 *
 * Define actions with cash targets
 */

namespace Vav\CashTarget\Controller;

use Vav\Core\Routing\Request;
use Vav\CashTarget\Block\Goal as GoalView;
use Vav\CashTarget\Model\Mapper\GoalMapper;
use Vav\CashTarget\Model\Domain\Goal;

class GoalController
{
    /**
     * @var Request;
     */
    private $request;

    /**
     * @var GoalMapper
     */
    private $mapper;

    /**
     * @var GoalView
     */
    private $block;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
        $this->block = new GoalView();
        $this->mapper = new GoalMapper();
    }
    public function indexAction()
    {
        $goal = $this->mapper->load(1);
        $this->block->setHeader(
            'Welcome to the Cash Target!' . PHP_EOL .
            'Please consider our help page for app usage:' . PHP_EOL . PHP_EOL
        );
        $this->block->setMessage($this->request->showHelp());

        $this->block->renderView();
    }

    public function getAction()
    {
        if ($id = $this->request->getParam('id')) {
            $goal = $this->mapper->load($id);
            if (!$goal instanceof Goal) {
                throw new \Exception('Invalid class.');
            }
            $this->block->setHeader('Welcome to the Cash Target!' . PHP_EOL);
            $this->block->setMessage(
                'You goal is: '. $goal->getName() . PHP_EOL .
                'Its price is $' . $goal->getPrice() . PHP_EOL
            );

            $this->block->renderView();
        } elseif ($this->request->getParam('all')) {
            $collection = $this->mapper->getCollection();
            echo PHP_EOL;
            print_r($collection->getData());
            echo PHP_EOL;
            die();
        }
    }

    public function setAction()
    {
        if (count($this->request->getParams())) {
            $goal = new Goal();
            $goal->setData($this->request->getParams());
            $this->mapper->insert($goal);
            echo PHP_EOL;
            print_r($goal);
            echo PHP_EOL;
            die();
        }
    }

    public function loadAction()
    {
        if ($id = $this->request->getParam('id')) {
            $goal = $this->mapper->load($id);
            $goal->setData($this->request->getParams());
            $this->mapper->update($goal);
            echo PHP_EOL;
            print_r($goal);
            echo PHP_EOL;
            die();
        }
    }

    public function deleteAction()
    {
        if ($id = $this->request->getParam('id')) {
            $this->mapper->delete($id);
        } elseif ($this->request->getParam('all')) {
            $this->mapper->delete(null, true);
        }
    }
} 