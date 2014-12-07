<?php
echo str_repeat(PHP_EOL, 5);
echo str_repeat(' ', 200) . $this->getHeader() . PHP_EOL . PHP_EOL;
echo str_repeat(' ', 150) . $this->getMessage();
echo str_repeat(PHP_EOL, 5);