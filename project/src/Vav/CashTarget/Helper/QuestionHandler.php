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
    private $question;

    public function __construct()
    {
        $this->input            = new ArgvInput();
        $this->output           = new ConsoleOutput();
        $this->questionHelper   = new QuestionHelper();
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

    public function ask()
    {
        return $this->questionHelper->ask(
            $this->input,
            $this->output,
            new Question($this->getQuestion())
        );
    }

    public function askToConfirm()
    {

    }

    public function askToChoose()
    {

    }
} 