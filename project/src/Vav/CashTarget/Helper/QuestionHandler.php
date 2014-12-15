<?php
/**
 * Interaction with user, question builder
 *
 * Class asks user for the additional questions to get the required data
 */

namespace Vav\CashTarget\Helper;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Helper\FormatterHelper;

class QuestionHandler
{
    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    /**
     * @var ArgvInput
     */
    private $input;

    /**
     * @var ConsoleOutput
     */
    private $output;

    /**
     * @var string - question
     */
    private $question = null;

    /**
     * @var array - choices
     */
    private $choices = [];

    /**
     * @var string
     */
    private $attention = null;

    public function __construct()
    {
        $this->input            = new ArgvInput();
        $this->output           = new ConsoleOutput();
        $this->questionHelper   = new QuestionHelper();
        $this->formatter        = new FormatterHelper();
    }

    /**
     * @param array $choices
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @param string $attention
     */
    public function setAttention($attention)
    {
        $this->attention = $attention;
    }

    /**
     * Ask question for entering data
     *
     * @return string
     */
    public function ask()
    {
        return $this->questionHelper->ask(
            $this->input,
            $this->output,
            new Question($this->getMessage())
        );
    }

    /**
     * Ask confirmation question - true/false
     *
     * @return string
     */
    public function askToConfirm()
    {
        return $this->questionHelper->ask(
            $this->input,
            $this->output,
            new ConfirmationQuestion($this->getMessage(), true)
        );
    }

    /**
     * Provide list of choices
     *
     * @return string
     */
    public function askToChoose()
    {
        return $this->questionHelper->ask(
            $this->input,
            $this->output,
            new ChoiceQuestion($this->getMessage(), $this->choices)
        );
    }

    /**
     * Compose message for asking
     *
     * @return string
     */
    private function getMessage()
    {
        $message = (!is_null($this->attention)) ? $this->attention . PHP_EOL : '';
        $message .= PHP_EOL . $this->question;

        return $message;
    }
} 