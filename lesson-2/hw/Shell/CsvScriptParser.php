<?php
namespace Shell;

use Vav\Parser;
use Vav\Executable;
use Vav\Parser\ParserException;

class CsvScriptParser extends AbstractShell implements Executable
{
    /**
     * @return array
     * @throws ParserException
     */
    public function execute()
    {
        Parser::ensure(
            !is_bool($this->getArg('f')),
            PHP_EOL.'=== Please specify the file for parsing ==='.PHP_EOL.PHP_EOL
        );

        $file         = $this->getArg('f');
        $delimiter    = ($this->getArg('d') && $this->getArg('d') !== true) ? $this->getArg('d') : null;
        $enclosure    = ($this->getArg('e') && $this->getArg('e') !== true) ? $this->getArg('e') : null;
        $header       = ($this->getArg('header') && $this->getArg('header') === 'y')
                            ? $this->getArg('header')
                            : null;
        $parser = new Parser($file, $delimiter, $enclosure, $header);

        return $parser->parse();
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