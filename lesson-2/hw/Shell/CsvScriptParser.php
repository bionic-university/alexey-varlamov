<?php
class Shell_CsvScriptParser extends Shell_Abstract
{
    /**
     * Start a file parsing
     */
    public function run()
    {
        if ($this->getArg('f') && $this->getArg('f') !== true) {
            try {
                $file         = $this->getArg('f');
                $delimiter    = ($this->getArg('d') && $this->getArg('d') !== true) ? $this->getArg('d') : null;
                $enclosure    = ($this->getArg('e') && $this->getArg('e') !== true) ? $this->getArg('e') : null;

                $parser       = new Parser($file, $delimiter, $enclosure);
                $parser->csv2Array();
            } catch (Parser_Exception $e) {
                echo $e->getMessage()."\n";
                exit;
            }
        } else {
            echo "\n=== Please specify a file for parsing ===\n\n";
            die($this->showHelp());
        }
    }

    /**
     * Show help
     */
    public function showHelp()
    {
        return <<<HELP
CSV Parser
------------------
Usage: php parser.php --[options]

--help      this help
--f         path to the CSV file for parsing
--d         fields delimiter. E.g. ',', ':', 'tab', '\|', '\;' etc.
--e         fields enclosure. E.g. '\'', '\"', 'empty' - to unset an enclosure, etc.

HELP;
    }
}