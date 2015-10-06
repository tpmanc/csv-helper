<?php

namespace core\helpers;

/**
 * Helper class for working with CSV
 */
class CsvHelper
{
    private $handle;

    private $skipCount = false;

    private $delimeter = ';';

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
     * Set number of line from top to skip
     * @param integer $n Count of lines to skip
     * @return core\helpers\CsvHelper Class instance
     */
    public function offset($n)
    {
        $this->skipCount = $n;
        return $this;
    }

    /**
     * Set delimeter for csv file
     * @param string $d Delimeter
     * @return core\helpers\CsvHelper Class instance
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
        while (!feof($this->handle)) {
            $buffer = fgetcsv($this->handle, 4096, ';');
            $num++;
            if ($this->skipCount !== false && $this->skipCount === $num) {
                continue;
            }
            call_user_func($func, $buffer);
        }
        fclose($this->handle);
    }
}