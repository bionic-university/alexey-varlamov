<?php
/**
 * Class Block for rendering response
 */

namespace Vav\CashTarget\Block;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Helper\FormatterHelper;
use Vav\CashTarget\Model\DomainObject;
use Vav\CashTarget\Model\Mapper\Collection;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\Table;
use Vav\CashTarget\Model\Domain\Goal as DomainGoal;

class Goal
{
    /**
     * @var Collection
     */
    private $goal;

    /**
     * @var string
     */
    private $header = '=== Welcome to Cash Targets ===';

    /**
     * @var ConsoleOutput
     */
    private $output;

    /**
     * @var int
     */
    private $overpaying = 0;

    /**
     * @var bool
     */
    private $isShowTactic = false;

    /**
     * @var FormatterHelper
     */
    private $formatter;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
        $this->formatter = new FormatterHelper();
    }

    /**
     * @param bool $isShowTactic
     */
    public function setIsShowTactic($isShowTactic)
    {
        $this->isShowTactic = $isShowTactic;
    }

    /**
     * @return int
     */
    public function getOverpaying()
    {
        return $this->overpaying;
    }

    /**
     * @param int $overpaying
     */
    public function setOverpaying($overpaying)
    {
        $this->overpaying = $overpaying;
    }

    /**
     * Include template file depending on type of action
     *
     * @param string $type - type of action
     */
    private $message;

    public function renderView($type = 'index')
    {
        $template = '';
        switch ($type) {
            case 'get':
            case 'tactic':
                $template = 'dev.phtml';
//                $template = '/template/goal/main.phtml';
                break;
            case 'report':
                $template = 'report.phtml';
                break;
            case 'optimizer':
                $template = 'optimizer.phtml';
                break;
            case 'delete':
                $template = 'deleted.php';
                break;
            case 'index':
            case 'empty':
            case 'save':
                $template = 'empty.php';
                break;
        }

        echo exec('clear');
        require dirname(__DIR__) . '/template/goal/' . $template;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        $formatedString = $this->formatter->formatBlock($this->header, 'bg=green;fg=white;options=bold');

        return $formatedString;
    }

    /**
     * @param string $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        $formatedString = $this->formatter->formatBlock($this->message, 'bg=blue;fg=white;options=bold');

        return $formatedString;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param Collection $goal
     */
    public function setGoal($goal)
    {
        $this->goal = $goal;
    }

    /**
     * @return Collection
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * Show target details
     *
     * @param \Vav\CashTarget\Model\Domain\Goal $goal
     * @return string $msg
     */
    public function getDetails(\Vav\CashTarget\Model\Domain\Goal $goal)
    {
        $msg = $this->getName($goal);
        $msg .= $this->getPrice($goal);

        return $msg;
    }

    /**
     * Render table of cash targets
     */
    public function showTable()
    {
        $table  = new Table($this->output);
        $style  = new TableStyle();

        $style->setHorizontalBorderChar('=')
            ->setVerticalBorderChar(' ')
            ->setCrossingChar(':')
            ->setPaddingChar(' ')
            ->setPadType(2);

        $table->setHeaders(array(
            'Id',
            'Name',
            'Price',
            'Paid sum',
            'Priority',
            'Deadline',
            'Incoming sum',
            'Incoming period',
            'Funding'
        ));

        $rows = [];
        foreach ($this->getGoal() as $goal) {
            /** @var DomainGoal $goal **/
            $rows[] = [
                $goal->getId(),
                $goal->getName(),
                '$' . $this->formatPrice($goal->getPrice()),
                '$' . $this->formatPrice($goal->getPaidSum()),
                (!is_null($goal->getPriority()) && $goal->getPriority() > 0) ? $goal->getPriority() : '- || -',
                (!is_null($goal->getDeadline()) && $goal->getDeadline() > 0) ? $goal->getDeadline() : '- || -',
                (!is_null($goal->getFSum()) && $goal->getFSum() > 0) ? $goal->getFSum() : '- || -',
                (!is_null($goal->getFPeriod())) ? $goal->getFPeriod() : '- || -',
                ((int)$goal->getAuto() === 1) ? 'Auto' : 'Manual'
            ];
        }
        $table->setRows($rows);

        $table->setStyle($style);
        $table->render();
    }

    public function showProgressBar()
    {
        $amount = 0;
        $paid   = 0;
        /*$msg    = '';
        $remain = '';*/

        foreach ($this->getGoal() as $goal) {
            /** @var DomainGoal $goal **/
            $amount += $goal->getPrice();
            $paid   += $goal->getPaidSum();
        }
        $result = $this->normalize($amount, $paid);

        if ($this->getGoal()->count() > 1) {
            $msg = 'Progress of achieving all cash targets:';
            $remain  = 'The remaining amount for accomplishing the targets is $';
            $remain .= $this->formatPrice($amount - $paid);
        } else {
            $this->getGoal()->rewind();
            $remain  = 'The remaining amount for accomplishing the target "';
            $remain .= $this->getGoal()->current()->getName() . '" is $' . $this->formatPrice($amount - $paid);
            $msg = 'Progress of achieving the target "' . $this->getGoal()->current()->getName() . '":';
        }

        $progressBar = new ProgressBar($this->output, 100);
        $progressBar->setProgress($result);
        $progressBar->setMessage($msg);
        $progressBar->setBarWidth(50);

        $progressBar->setFormat(
            ' %message%'. str_repeat(PHP_EOL, 2) .
            ' $' . $this->formatPrice($paid) . '/$' . $this->formatPrice($amount) .
            ' [%bar%] %percent%%' . str_repeat(PHP_EOL, 2) .
            ' ' . $remain
        );


        $progressBar->display();
    }

    /**
     * Calculate the date of reaching a target
     *
     * @return string
     * @throws \Exception
     */
    public function showFinishedDate()
    {
        $finishedDate = 0;
        $seconds = 0;
        $goal = $this->getGoal()->current();
        if (!$goal instanceof DomainGoal) {
            throw new \Exception('The object should be instance of the class "DomainObject\\Goal"');
        }

        $date = $goal->getCreatedDate();
        if (!is_null($goal->getDeadline())) {
            $digit = filter_var($goal->getDeadline(), FILTER_SANITIZE_NUMBER_INT);
            switch (substr($goal->getDeadline(), -1, 1)) {
                case 'd':
                    $seconds = $digit * 24 * 60 * 60;
                    break;
                case 'm':
                    $seconds = $digit * 30 * 24 * 60 * 60;
                    break;
                case 'y':
                    $seconds = $digit * 365 * 24 * 60 * 60;
                    break;
            }
            $finishedDate = date('m/d/Y', strtotime($date) + $seconds);
        }
        
        return ' The target: "' . $goal->getName() . '" will be reached ' . $finishedDate;
    }

    /**
     * Show tactic or not
     *
     * @return bool
     */
    public function isShowTactic()
    {
        return $this->isShowTactic;
    }

    public function getTactics()
    {

    }

    /**
     * Show possible tactics of achieving the targets
     */
    public function showTactic()
    {
        $table   = new Table($this->output);
        $periods = ['day', 'month', 'year'];
        /** @var DomainGoal $goal **/
        $goal    = $this->getGoal()->current();

        $table->setHeaders([
            '#',
            'Period',
            'The amount of payment for the period',
            'QTY of the required payments'
        ]);

        foreach ($periods as $i => $period) {
            $remainedSum = $goal->getPrice()/* - $goal->getPaidSum()*/;
            $periodQty = filter_var($goal->getDeadline(), FILTER_SANITIZE_NUMBER_INT);
            $qty = [];
            $result = [];
            switch (substr($goal->getDeadline(), -1, 1)) {
                case 'd':
                    $months = ($periodQty > 30) ? ceil($periodQty / 30) : 1;
                    $years  = ($periodQty > 365) ? ceil($periodQty / 365) : 1;
                    $result = [
                        $remainedSum / $periodQty,
                        ($months > 1) ? $remainedSum / $months : $remainedSum,
                        ($years > 1)  ? $remainedSum / $years  : $remainedSum
                    ];
                    $qty    = [$periodQty, $months, $years];
                    break;
                case 'm':
                    $years  = ($periodQty > 12) ? ceil($periodQty / 12) : 1;
                    $result = [
                        $remainedSum / ($periodQty * 30 ),
                        $remainedSum / $periodQty,
                        ($years > 1)  ? $remainedSum / $years  : $remainedSum
                    ];
                    $qty    = [$periodQty * 30, $periodQty, $years];
                    break;
                case 'y':
                    $result = [
                        $remainedSum / ($periodQty * 365 ),
                        $remainedSum / ($periodQty * 12),
                        $remainedSum / $periodQty
                    ];
                    $qty    = [$periodQty * 365, $periodQty * 12, $periodQty];
                    break;
            }
            $result = array_map(
                function ($el) {
                    return $this->formatPrice($el);
                },
                $result
            );

            $table->addRow([
                $i + 1,
                'Each ' . $period,
                '$' . $result[$i],
                $qty[$i]
            ]);
        }
        echo str_repeat(PHP_EOL, 2);
        $table->render();
    }

    /**
     * Format price to: 50,000.00
     *
     * @param float $price
     * @return float
     */
    public function formatPrice($price)
    {
        return number_format($price, 2, ',', '.');
    }

    /**
     * Convert number to percent
     *
     * @param float $amount
     * @param float $paid
     * @return int
     */
    public function normalize($amount, $paid)
    {
        $result = 0;
        if ($paid > 0) {
            $result = ($paid * 100) / $amount;
            $result = round($result);
        }

        return $result;
    }
}