<?php
/**
 * @author Chukancev Nikita <tpxtrime@mail.ru>
 */
namespace tpmanc\csvhelper;

use tpmanc\csvhelper\CsvFile;
use tpmanc\csvhelper\CsvBase;

/**
 * Helper class for working with CSV files
 */
class CsvHelper extends CsvBase
{
    private $handle;

    /**
     * @var integer|boolean Count of lines from top to skip
     */
    private $skipCount = false;

    /**
     * @var integer|boolean Lines count for reading
     */
    private $limit = false;

    /**
     * Create new csv file
     * @return CsvFile Class instance
     */
    public static function create()
    {
        return new CsvFile();
    }

    /**
     * Open csv file
     * @param string $path Csv file path
     * @return CsvHelper Class instance
     */
    public static function open($path)
    {
        $instance = new self();
        $instance->filePath = $path;
        $instance->handle = fopen($path, "r");

        return $instance;
    }

    /**
     * Set lines count limit
     * @param integer $count Lines count
     * @return CsvHelper Class instance
     */
    public function limit($count)
    {
        $this->limit = $count;
        return $this;
    }

    /**
     * Set number of line from top to skip
     * @param integer $n Count of lines to skip
     * @return CsvHelper Class instance
     */
    public function offset($n)
    {
        $this->skipCount = $n;
        return $this;
    }

    /**
     * Read opened csv file
     * @param callback $func Function that execute for every file line
     * @return void
     */
    public function parse($func)
    {
        $num = 0;
        if ($this->limit !== false) {
            $limit = $this->limit;
            if ($this->skipCount !== false) {
                $limit += $this->skipCount;
            }
        } else {
            $limit = false;
        }
        while (!feof($this->handle)) {
            $buffer = fgetcsv($this->handle, 4096, $this->delimiter);
            if ($buffer === false) {
                continue;
            }

            // check limit
            if ($limit !== false && $limit === $num) {
                break;
            }

            $num++;

            // check offset
            if ($this->skipCount !== false && $this->skipCount >= $num) {
                continue;
            }

            // change encoding
            if ($this->toEncoding !== false && $this->fromEncoding !== false) {
                foreach ($buffer as &$b) {
                    $b = iconv($this->fromEncoding, $this->toEncoding, $b);
                }
            }
            call_user_func($func, $buffer);
        }
        fclose($this->handle);
    }
}
