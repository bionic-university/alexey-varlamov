<?php
echo str_repeat(PHP_EOL, 5);
echo str_repeat(' ', 200);
$this->output->writeln($this->getHeader());
echo str_repeat(PHP_EOL, 3);
echo str_repeat(' ', 150);
$this->output->write($this->getMessage());
echo str_repeat(PHP_EOL, 5);