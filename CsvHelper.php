<?php

namespace core\helpers;

/**
 * Helper class for working with CSV
 */
class CsvHelper
{
    private $handle;

    /**
     * @var integer|boolean Count of lines from top to skip
     */
    private $skipCount = false;

    /**
     * @var string Csv file rows delimeter
     */
    private $delimeter = ';';

    /**
     * @var integer|boolean Lines count for reading
     */
    private $limit = false;

    /**
     * Open csv file
     * @param string $path Csv file path
     * @return core\helpers\CsvHelper Class instance
     */
    public static function open($path)
    {
        $instance = new self();
        $instance->handle = fopen($path, "r");

        return $instance;
    }

    /**
     * Set lines count limit
     * @param integer $count Lines count
     * @return this Class instance
     */
    public function limit($count)
    {
        $this->limit = $count;
        return $this;
    }

    /**
     * Set number of line from top to skip
     * @param integer $n Count of lines to skip
     * @return this Class instance
     */
    public function offset($n)
    {
        $this->skipCount = $n;
        return $this;
    }

    /**
     * Set delimeter for csv file
     * @param string $d Delimeter
     * @return this Class instance
     */
    public function delimeter($d)
    {
        $this->delimeter = $d;
        return $this;
    }

    /**
     * Read opened csv file
     * @param function $func Function that execute for every file line
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
            $buffer = fgetcsv($this->handle, 4096, $this->delimeter);
            $num++;
            if ($this->skipCount !== false && $this->skipCount === $num) {
                continue;
            }
            if ($limit !== false && $limit === $num) {
                break;
            }
            call_user_func($func, $buffer);
        }
        fclose($this->handle);
    }
}