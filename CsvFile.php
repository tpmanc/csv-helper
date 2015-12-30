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
     * @var string File content
     */
    private $content = '';

    /**
     * Constructor
     * @param string New file path
     */
    public function __construct(){}

    /**
     * Set file content
     * @param string $fileContent File content
     * @return object this
     */
    public function setContent($fileContent)
    {
        if ($this->fromEncoding !== false && $this->toEncoding !== false) {
            $fileContent = iconv($this->fromEncoding, $this->toEncoding, $fileContent);
        }
        $this->content = $fileContent;
        return $this;
    }

    /**
     * Add line to file
     * @param string|array $line New line to file
     * @return object this
     */
    public function addLine($line)
    {
        if (is_array($line)) {
            $strLine .= implode($this->delimiter, $line) . "\n";
        } else {
            $strLine .= $line . "\n";
        }
        if ($this->fromEncoding !== false && $this->toEncoding !== false) {
            $strLine = iconv($this->fromEncoding, $this->toEncoding, $strLine);
        }
        $this->content .= $strLine . "\n";
        return $this;
    }

    /**
     * Save content to file
     * @return void
     */
    public function save($filePath)
    {
        try {
            file_put_contents($filePath, $this->content);
        } catch (Exception $e) {
            throw new \RuntimeException($e);
        }
    }
}