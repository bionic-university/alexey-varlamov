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
use Vav\CashTarget\Helper\QuestionHandler;
use Symfony\Component\Console\Output\ConsoleOutput;

class GoalController
{
    /**
     * Required fields
     *
     * @var array
     */
    private $requiredFields = [
        'name',
        'price',
        'deadline',
        /*[
            'fperiod',
            'fprice'
        ]*/
    ];

    /**
     * Missed fields
     *
     * @var array
     */
    private $missed = [];

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
     * @var QuestionHandler
     */
    private $questionHandler;

    /**
     * Setting up of the predefined classes
     *
     * @param Request $request
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request;
        $this->block   = new GoalView();
        $this->mapper  = new GoalMapper();
        $this->questionHandler = new QuestionHandler();
        $this->output = new ConsoleOutput();
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

        if (is_null($goals)) {
            $this->block->setMessage(
                'You do not define any targets yet. Please consider our help or create a new target.' . PHP_EOL .
                $this->request->showHelp()
            );
            $type = 'empty';
        } elseif ($goals->count() > 0) {
            $this->block->setGoal($goals);
            $type = 'get';
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
        $msg = '';
        foreach ($this->requiredFields as $param) {
            if (!array_key_exists($param, $this->request->getParams())) {
                array_push($this->missed, $param);
            }
        }

        if (count($this->missed) > 0) {
            $msg = 'You have not set the target\'s "' . implode(', ', $this->missed) . '".';
            $msg .= ' These params are required, do you want to continue and set them?(Y/n)';
            $this->questionHandler->setQuestion($msg);
            $msg = '';
            $confirmation = $this->questionHandler->askToConfirm();
            if ($confirmation) {
                $empty = [];
                foreach ($this->missed as $param) {
                    $this->questionHandler->setQuestion('Set target ' . $param . ':' . PHP_EOL);
                    $response = $this->questionHandler->ask();
                    $this->request->setParam($param, $response);
                    if (is_null($response)) {
                        $empty[] = $param;
                    }
                }
                if (count($empty) > 0) {
                    $msg = 'You have not set the target\'s "' . implode(', ', $empty) . '".' . PHP_EOL;
                    $msg .= 'You can change target options at any time using the method "--load", e.g. "--load id=4 name=notebook price=20000"';
                    $this->block->setMessage($msg);
                    $this->block->renderView('empty');
                }
            }
        }

        $goal = new Goal();
        $goal->setData($this->request->getParams());
        $this->mapper->insert($goal);
        $msg = 'The target "' . $goal->getName() . '" was successfully created.' . PHP_EOL . $msg;
        $this->block->setMessage($msg);

        $this->block->renderView('save');
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
        $this->block->renderView('tactic');
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

    public function cronAction()
    {
        $goals = $this->mapper->getCollection();
        foreach ($goals as $goal) {
            /** @var Goal $goal **/
            if ((int) $goal->getAuto() === 1) {
                $this->output->writeln('--success--');
            }
        }
    }
} 