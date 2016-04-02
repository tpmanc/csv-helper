<?php
/**
 * @author Chukancev Nikita <tpxtrime@mail.ru>
 */
namespace tpmanc\csvhelper;

/**
 * Csv base class
 */
class CsvBase
{
    /**
     * @var string Csv file rows delimiter
     */
    protected $delimiter = ';';

    /**
     * @var string|boolean Set encoding from `$fromEncoding` to `$toEncoding`
     */
    protected $fromEncoding = false;

    /**
     * @var string|boolean Set encoding from `$fromEncoding` to `$toEncoding`
     */
    protected $toEncoding = false;

    /**
     * Set delimiter for csv file
     * @param string $d Delimiter
     * @return object Class instance
     */
    public function delimiter($d)
    {
        $this->delimiter = $d;
        return $this;
    }

    /**
     * Set charsets for encoding
     * @param string $to To charset
     * @param bool|string $from From charset
     * @return object Class instance
     */
    public function encode($to, $from = false)
    {
        if ($from !== false) {
            $this->fromEncoding = $from;
        }
        $this->toEncoding = $to;
        return $this;
    }
}