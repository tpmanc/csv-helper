<?php
/**
 * @author Chukancev Nikita <tpxtrime@mail.ru>
 */
namespace tpmanc\csvhelper;

use tpmanc\csvhelper\CsvBase;

/**
 * Csv file
 */
class CsvFile extends CsvBase
{
    /**
     * @var array File content
     */
    private $content = [];

    /**
     * Constructor
     * @return CsvFile
     */
    public function __construct()
    {
    }

    /**
     * Set file content
     * @param string $fileContent File content
     * @return object this
     */
    public function setContent($fileContent)
    {
        $this->content = [$fileContent];
        return $this;
    }

    /**
     * Add line to file
     * @param string|array $line New line to file
     * @return object this
     */
    public function addLine($line)
    {
        $this->content[] = $line;
        return $this;
    }

    /**
     * Save content to file
     * @param $filePath
     */
    public function save($filePath)
    {
        $strLine = '';
        foreach ($this->content as $line) {
            if (is_array($line)) {
                $strLine .= implode($this->delimiter, $line) . "\n";
            } else {
                $strLine .= $line . "\n";
            }
        }
        try {
            if ($this->toEncoding !== false) {
                $strLine = iconv("UTF-8", $this->toEncoding, $strLine);
            }
            file_put_contents($filePath, $strLine);
        } catch (\Exception $e) {
            throw new \RuntimeException($e);
        }
    }
}
