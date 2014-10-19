<?php

/**
 * Class Parser
 *
 * Convert csv file into array
 */
class Parser/* extends SplFileObject*/
{
    protected $file         = null;
    protected $delimiter    = null;
    protected $enclosure    = null;

    /**
     * @param $file
     * @param $delimiter
     * @param $enclosure
     */
    public function __construct($file, $delimiter, $enclosure)
    {
        $this->validate($file);
        $this->file = new SplFileObject($file);
        $this->delimiter = (isset($delimiter)) ? $delimiter : $this->file->getCsvControl()[0];
        if ($enclosure === 'empty') {
            $this->enclosure = '';
        } else {
            $this->enclosure = (isset($enclosure)) ? $enclosure : $this->file->getCsvControl()[1];
        }
    }

    public function csv2Array()
    {
        $parsed = $this->file->fgetcsv(
            $this->delimiter,
            $this->enclosure
        );
        $parsed2 = $this->file->next()->fgetcsv(
            $this->delimiter,
            $this->enclosure
        );
        print_r($parsed2);
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