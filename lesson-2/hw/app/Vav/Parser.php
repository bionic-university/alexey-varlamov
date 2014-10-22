<?php
namespace Vav;

use SplFileObject;
use Vav\Parser\ParserException;

/**
 * Class Parser
 *
 * Convert csv file into array
 */
class Parser
{
    /**
     * @var SplFileObject
     */
    protected $file;
    protected $delimiter;
    protected $enclosure;
    protected $header;

    /**
     * @param $file
     * @param $delimiter
     * @param $enclosure
     * @param $header
     */
    public function __construct($file, $delimiter, $enclosure, $header)
    {
        $this->validate($file);
        $this->setFile($file);
        $this->setDelimiter($delimiter);
        $this->setEnclosure($enclosure);
        $this->header = (isset($header)) ? $header : null;
    }

    /**
     * @param $file - csv file name
     */
    private function setFile($file)
    {
        $this->file = new SplFileObject($file);
        $this->file->setFlags(SplFileObject::READ_CSV);
        $this->file->setCsvControl($this->delimiter, $this->enclosure);
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
     * Set delimiter for csv file
     *
     * @param $delimiter
     * @return null|string
     */
    private function setDelimiter($delimiter)
    {
        if ($delimiter === "\t" || $delimiter === 'tab' || $delimiter === 't') {
            $delimiter = "\t";
        } elseif (is_null($delimiter)) {
            $delimiter = $this->file->getCsvControl()[0];
        }

        return $this->delimiter = $delimiter;
    }

    /**
     * @param $enclosure
     */
    private function setEnclosure($enclosure)
    {
        if ($enclosure === 'empty') {
            $this->enclosure = '';
        } else {
            $this->enclosure = (isset($enclosure)) ? $enclosure : $this->file->getCsvControl()[1];
        }
    }

    /**
     * @param $file
     * @throws ParserException
     */
    private function validate($file)
    {
        self::ensure(
            file_exists($file),
            'The file ' . $file . ' does not exists.'.PHP_EOL
        );
        self::ensure(
            is_readable($file),
            'The file ' . $file . ' is not readable. Please specify a readable file.'.PHP_EOL
        );
        self::ensure(
            filesize($file),
            'The file ' . $file . ' is empty. Please specify another file.'.PHP_EOL
        );
    }

    /**
     * @param $expr
     * @param $message
     * @throws ParserException
     */
    public static function ensure($expr, $message)
    {
        if (!$expr) {
            throw new ParserException($message);
        }
    }
}