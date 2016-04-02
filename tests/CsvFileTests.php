<?php

use tpmanc\csvhelper\CsvHelper;

class CsvFileTests extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $path = ROOT . '/temp/file.csv';
        $file = CsvHelper::create();
        $file->addLine('1|France|Paris');
        $file->addLine([
            2,
            'Russia',
            'Moscow'
        ]);
        $file->addLine([
            3,
            'Germany',
            'Berlin'
        ]);
        $file->delimiter('|');
        $file->save($path);
        $this->assertFileExists($path);

        $path = ROOT . '/temp/file-cp.csv';
        $file = CsvHelper::create();
        $file->addLine('1%France%Paris');
        $file->addLine([
            2,
            'Russia',
            'Moscow'
        ]);
        $file->addLine([
            3,
            'Germany',
            'Berlin'
        ]);
        $file->delimiter('%')->encode('ASCII')->save($path);
        $this->assertFileExists($path);
    }

    public function testRead()
    {
        $path = ROOT . '/temp/file.csv';
        $array = [];
        CsvHelper::open($path)->delimiter('|')->parse(function ($line) use (&$array) {
            $array[] = $line[1];
        });
        $this->assertEquals($array, ['France', 'Russia', 'Germany']);

        $array = [];
        CsvHelper::open($path)->delimiter('|')->offset(1)->parse(function ($line) use (&$array) {
            $array[] = $line[1];
        });
        $this->assertEquals($array, ['Russia', 'Germany']);

        $path = ROOT . '/temp/file-cp.csv';
        $array = [];
        CsvHelper::open($path)->delimiter('%')->parse(function ($line) use (&$array) {
            $array[] = $line[2];
        });
        $this->assertEquals($array, ['Paris', 'Moscow', 'Berlin']);

        $array = [];
        CsvHelper::open($path)->delimiter('%')->limit(1)->parse(function ($line) use (&$array) {
            $array[] = $line[2];
        });
        $this->assertEquals($array, ['Paris']);
    }
}