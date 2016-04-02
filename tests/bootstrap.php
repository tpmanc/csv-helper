<?php

defined('ROOT') or define('ROOT', __DIR__ . "/..");

require(ROOT . '/vendor/autoload.php');

$tempDirPath = ROOT . '/temp';
if (is_dir($tempDirPath)) {
    $files = glob($tempDirPath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    rmdir($tempDirPath);
}
mkdir($tempDirPath);

