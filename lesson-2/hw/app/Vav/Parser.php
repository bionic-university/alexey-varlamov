<?php
namespace Vav;

use SplFileObject;
use Shell\ShellException;
use Vav\Parser\ParserException;

/**
 * Class Parser
 *
 * Convert csv file into array
 */
class Parser implements Parsable
{
    /**
     * @var SplFileObject
     */
    protected $file;

    /**
     * @var bool $header - include CSV header or not
     */
    protected $header;

    /**
     * @param $file - csv file name
     */
    public function setFile($file)
    {
        $this->validate($file);
        $this->file = new SplFileObject($file);
        $this->file->setFlags(SplFileObject::READ_CSV);
    }

    /**
     * @param string $delimiter
     * @param string $enclosure
     * @param null $header
     */
    public function setCsvControl($delimiter = ',', $enclosure = '"', $header = null)
    {
        $delimiter = $this->setDelimiter($delimiter);
        $enclosure = $this->setEnclosure($enclosure);
        $this->setHeader($header);
        $this->ensure(
            $this->file instanceof SplFileObject,
            'Please, specify the file first.'.PHP_EOL,
            'Vav\Parser\ParserException'
        );
        $this->file->setCsvControl($delimiter, $enclosure);
    }

    /**
     * Parse csv
     *
     * @return array
     */
    public function parse()
    {
        $parsedCsv = $this->csvToArray();

        return $parsedCsv;
    }

    /**
     * Convert csv file into array
     *
     * @return array
     */
    private function csvToArray()
    {
        $header = [];
        $values = [];
        foreach ($this->file as $indx => $row) {
            if (isset($this->header) && $indx === 0) {
                $header = array_values($row);
            } elseif (!$this->header) {
                $values[] = $row;
            } elseif ($indx > 0 && !empty($header)) {
                $values[] = array_combine($header, $row);
            }
        }

        return $values;
    }

    /**
     * @param $delimiter
     * @return string $delimiter
     */
    private function setDelimiter($delimiter)
    {
        if ($delimiter === "\t" || $delimiter === 'tab' || $delimiter === 't') {
            $delimiter = "\t";
        } elseif (is_bool($delimiter)) {
            $delimiter = $this->file->getCsvControl()[0];
        }

        return $delimiter;
    }

    /**
     * @param $enclosure
     * @return string
     */
    private function setEnclosure($enclosure)
    {
        if ($enclosure === 'empty') {
            $enclosure = '';
        } elseif(is_bool($enclosure)) {
            $enclosure = $this->file->getCsvControl()[1];
        }

        return $enclosure;
    }

    /**
     * @param $header
     */
    private function setHeader($header)
    {
        if ($header === 'y') {
            $header = true;
        } else {
            $header = null;
        }

        $this->header = $header;
    }

    /**
     * @param $file
     * @throws ParserException
     */
    private function validate($file)
    {
        self::ensure(
            file_exists($file),
            'The file ' . $file . ' does not exists.'.PHP_EOL,
            'Vav\Parser\ParserException'
        );
        self::ensure(
            is_readable($file),
            'The file ' . $file . ' is not readable. Please specify a readable file.'.PHP_EOL,
            'Vav\Parser\ParserException'
        );
        self::ensure(
            filesize($file),
            'The file ' . $file . ' is empty. Please specify another file.'.PHP_EOL,
            'Vav\Parser\ParserException'
        );
    }

    /**
     * @param $expr
     * @param $message
     * @param $exceptionClass
     * @throws ParserException | ShellException
     */
    public static function ensure($expr, $message, $exceptionClass)
    {
        if (!$expr) {
            throw new $exceptionClass($message);
        }
    }
}