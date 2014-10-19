<?php

/**
 * Class Parser
 *
 * Convert csv file into array
 */
class Parser
{
    protected $file         = null;
    protected $delimiter    = null;
    protected $enclosure    = null;
    protected $header       = null;
    protected $values       = array();

    /**
     * @param $file
     * @param $delimiter
     * @param $enclosure
     * @param $header
     */
    public function __construct($file, $delimiter, $enclosure, $header)
    {
        $this->validate($file);
        $this->file = new SplFileObject($file);
        $this->file->setFlags(SplFileObject::READ_CSV);
        $this->delimiter    = $this->setDelimiter($delimiter);
        if ($enclosure === 'empty') {
            $this->enclosure = '';
        } else {
            $this->enclosure = (isset($enclosure)) ? $enclosure : $this->file->getCsvControl()[1];
        }
        $this->header = (isset($header)) ? $header : null;
        $this->file->setCsvControl($this->delimiter, $this->enclosure);
    }

    /**
     * Convert csv file into array
     *
     * @return array
     */
    public function csv2Array()
    {
        $header = array();
        foreach ($this->file as $indx => $row) {
            if (isset($this->header) && $indx === 0) {
                $header = array_values($row);
            } elseif (!$this->header) {
                $this->values[] = $row;
            } elseif ($indx> 0 && !empty($header)) {
                $this->values[] = array_combine($header, $row);
            }
        }

        return $this->values;
    }

    /**
     * Set delimiter for csv file
     *
     * @param $delimiter
     * @return null|string
     */
    public function setDelimiter($delimiter)
    {
        if ($delimiter === "\t" || $delimiter === "tab" || $delimiter === "t") {
            $delimiter = "\t";
        } elseif (is_null($delimiter)) {
            $delimiter = $this->file->getCsvControl()[0];
        }

        return $delimiter;
    }

    /**
     * Validate input file
     *
     * @param $file
     * @throws Parser_Exception
     */
    protected function validate($file)
    {
        $this->ensure(
            file_exists($file),
            "The file '{$file}' does not exists."
        );
        $this->ensure(
            is_readable($file),
            "The file '{$file}' is not readable. Please specify a readable file."
        );
        $this->ensure(
            filesize($file),
            "The file '{$file}' is empty. Please specify another file."
        );
    }

    /**
     * Generate exception
     *
     * @param $expr
     * @param $message
     * @throws Parser_Exception
     */
    protected function ensure($expr, $message)
    {
        if (!$expr) {
            throw new Parser_Exception($message);
        }
    }
}