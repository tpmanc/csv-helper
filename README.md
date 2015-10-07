# CSV Helper
Helper class for working with CSV files.

## Install via Composer

Run the following command

```bash
$ composer require tpmanc/csvhelper "*"
```

or add

```bash
$ "tpmanc/csvhelper": "*"
```

to the require section of your `composer.json` file.

## File reading

file.csv:
```
Russia;Moscow;
France;Paris;
Great Gritain;London;
```

```php
use tpmanc\csvhelper\CsvHelper;

...

CsvHelper::open('files/file.csv')->parse(function($line) {
    echo $line[0] . ': ' . $line[1];
});
```

Result:
```
Russia: Moscow
France: Paris
Great Gritain: London
```

## Custom delimiter

file.csv:
```
Russia|Moscow|
France|Paris|
Great Gritain|London|
```

```php
use tpmanc\csvhelper\CsvHelper;

...

CsvHelper::open('files/file.csv')->delimiter('|')->parse(function($line) {
    echo $line[0] . ': ' . $line[1];
});
```

Result:
```
Russia: Moscow
France: Paris
Great Gritain: London
```

## Offset and limit

file.csv:
```
Russia;Moscow;
France;Paris;
Great Gritain;London;
```

```php
use tpmanc\csvhelper\CsvHelper;

...

CsvHelper::open('files/file.csv')->offset(1)->limit(1)->parse(function($line) {
    echo $line[0] . ': ' . $line[1];
});
```

Result:
```
France: Paris
```

## Using variables from the parent scope

file.csv:
```
Russia;Moscow;
France;Paris;
Great Gritain;London;
```

```php
use tpmanc\csvhelper\CsvHelper;

...

$lineCount = 0;
$array = [];
CsvHelper::open('files/file.csv')->parse(function($line) use(&$lineCount, &$array) {
    $lineCount++;
    $array[] = $line[0];
});
echo $lineCount;
echo $array[0];
echo $array[1];
```

Result:
```
3
Russia
France
```