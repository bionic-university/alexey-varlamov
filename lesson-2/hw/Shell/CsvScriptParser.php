<?php
namespace Shell;

use Vav\Parser;
use Vav\Executable;

class CsvScriptParser extends AbstractShell implements Executable
{
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @return array
     */
    public function execute()
    {
        $this->parser = new Parser();
        $this->defineCsvControl();

        return $this->parser->parse();
    }

    /**
     *
     * @throws ShellException
     */
    private function defineCsvControl()
    {
        Parser::ensure(
            !is_bool($this->getArg('f')),
            PHP_EOL.'=== Please specify the file for parsing ==='.PHP_EOL.PHP_EOL,
            'Shell\ShellException'
        );

        $this->parser->setFile($this->getArg('f'));
        $this->parser->setCsvControl(
            $this->getArg('d'),
            $this->getArg('e'),
            $this->getArg('header')
        );
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

--help(h)   this help
--f         path to the CSV file for parsing
--d         fields delimiter. E.g. ',', ':', 'tab', '\|', '\;' etc.
--e         fields enclosure. E.g. '\'', '\"', 'empty' - to unset an enclosure, etc.
--header    possible values: 'y' - first line is a header; 'n' - no header;


HELP;
    }
}