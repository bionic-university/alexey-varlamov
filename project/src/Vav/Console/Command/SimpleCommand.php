<?php
namespace Vav\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SimpleCommand extends Command
{
    protected function configure()
    {
        $this->setName('hello:world')
            ->setDescription('Outputs: \'Hello world!\'');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Hello world<info>');
    }
} 