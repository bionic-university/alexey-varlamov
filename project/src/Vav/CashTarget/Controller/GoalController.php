<?php
/**
 * Define common actions with cash targets
 *
 * @package Vav\CashTarget\Controller
 * @author Alexey Varlamov
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

    /**
     * Setting up of the predefined classes
     *
     * @param Request $request
     */
    public function __construct(Request $request = null)
    {
        $this->request  = $request;
        $this->block    = new GoalView();
        $this->mapper   = new GoalMapper();
    }

    /**
     * Default page of the app
     */
    public function indexAction()
    {
        $this->block->setHeader(

            'Welcome to the Cash Target!' . PHP_EOL .
            'Please consider our help page for app usage:' . PHP_EOL . PHP_EOL
        );
        $this->block->setMessage($this->request->showHelp());

        $this->block->renderView();
    }

    /**
     * Retrieve particular || all targets and show them to user
     *
     * @throws \Exception
     */
    public function getAction()
    {
        $goals = null;
        if ($id = $this->request->getParam('id')) {
            $goal = $this->mapper->load($id);
            $goals = $goal->getCollection();
            $goals->add($goal);
        } elseif ($this->request->getParam('all')) {
            $goals = $this->mapper->getCollection();
        }

        if ($goals->count() > 0) {
            $this->block->setGoal($goals);
            $type = 'get';
        } else {
            $this->block->setMessage(
                'You do not define any targets yet. Please consider our help to create a new target.' . PHP_EOL .
                $this->request->showHelp()
            );
            $type = 'empty';
        }

        $this->block->renderView($type);
    }

    /**
     * Create and save new target
     *
     * @throws \Exception
     */
    public function setAction()
    {
        if (count($this->request->getParams())) {
            if (
                !$this->request->getParam('name') ||
                !$this->request->getParam('price') ||
                !(
                    $this->request->getParam('deadline') ||
                    $this->request->getParam('fsum') &&
                    $this->request->getParam('fperiod')
                )
            ) {
                $this->block->setMessage(
                    'Please specify all required parameters:' . PHP_EOL .
                    '- "name";' . PHP_EOL .
                    '- "price";' . PHP_EOL .
                    '- "deadline" or "fperiod" and "fsum"' . PHP_EOL
                );
                $this->block->renderView('empty');
                throw new \Exception('Specify required params.');
            }
            $goal = new Goal();
            $goal->setData($this->request->getParams());
            $this->mapper->insert($goal);
            $this->block->setMessage(
                'The target "' . $goal->getName() . '" was successfully created.'
            );

            $this->block->renderView('save');
        }
    }

    /**
     * Load existing goal and handle it
     *
     * @throws \Exception
     */
    public function loadAction()
    {
        if ($id = $this->request->getParam('id')) {
            $goal = $this->mapper->load($id);

            if (!is_null($goal)) {
                $data = $this->request->getParams();
                if (
                    $funds = $this->request->getParam('addFunds') &&
                    $goal->getPaidSum() < $goal->getPrice()
                ) {
                    $funds = filter_var($funds, FILTER_SANITIZE_NUMBER_FLOAT);
                    $goal->setPaidSum($goal->getPaidSum() + $funds);

                    if ($goal->getPrice() < $goal->getPaidSum()) {
                        $goal->setPaidSum($goal->getPrice());
                        $this->block->setOverpaying($goal->getPaidSum() - $goal->getPrice());
                    }
                    unset($data['addFunds']);
                }

                $goal->setData($data);
                $this->mapper->update($goal);
                $goals = $goal->getCollection();
                $goals->add($goal);
                $this->block->setGoal($goals);
                $this->block->setMessage('The target was successfully updated.');
                $type = 'index';
            } else {
                $this->block->setMessage(
                    'You do not have such target. ' . PHP_EOL .
                    'Please use the command "php path_to_script/index.php -get all" - to see a list of existing targets.' .
                    PHP_EOL . 'Or create new target if you do not have any target yet.'
                );
                $type = 'empty';
            }
            $this->block->renderView($type);
        }
    }

    public function tacticAction()
    {
        if (!$this->request->getParam('id')) {
            throw new \HttpInvalidParamException('The param "id" is required.');
        }
        $goal = $this->mapper->load($this->request->getParam('id'));

        if (is_null($goal)) {
            $msg = 'Target with id: ' . $this->request->getParam('id') . ' does not exists.';
            throw new \BadMethodCallException($msg);
        }

        $goals = $goal->getCollection();
        $goals->add($goal);
        $this->block->setGoal($goals);
        $this->block->setIsShowTactic(true);
        $this->block->setHeader(' ===  Cash Target Tactics === ');
        $this->block->renderView();
    }

    /**
     * Delete existing target
     */
    public function deleteAction()
    {
        if ($id = $this->request->getParam('id')) {
            $this->mapper->delete($id);
            $this->block->setMessage('The target was deleted.');
        } elseif ($this->request->getParam('all')) {
            $this->mapper->delete(null, true);
            $this->block->setMessage('The targets were deleted.');
        }
        $this->block->renderView('delete');
    }
} 