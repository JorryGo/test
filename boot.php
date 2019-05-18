<?php
/**
 * Boot file with base settings and register classes autoloader
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);


spl_autoload_register(function (string $className) {

    $filename = __DIR__ . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

    if (file_exists($filename)) {
        require $filename;
    }
});