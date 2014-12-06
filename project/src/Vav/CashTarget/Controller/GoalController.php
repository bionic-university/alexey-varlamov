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

        if (!is_null($goals)) {
            $this->block->setGoal($goals);
            $this->block->renderView();
        }
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
                $this->block->renderView();
                throw new \Exception('Specify required params.');
            }
            $goal = new Goal();
            $goal->setData($this->request->getParams());
            $this->mapper->insert($goal);
            $this->block->setMessage(
                'The target "' . $goal->getName() . '" was successfully created.'
            );
            $this->block->renderView();
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
            $goal->setData($this->request->getParams());
            $this->mapper->update($goal);
            $goals = $goal->getCollection();
            $goals->add($goal);
            $this->block->setGoal($goals);
            $this->block->setMessage('The target was successfully updated.');
            $this->block->renderView();
        }
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
        $this->block->renderView();
    }
} 