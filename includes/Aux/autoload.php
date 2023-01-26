<?php
function autoloader($className)
{
//echo $className . '   ';
    $fileName = str_replace("\\", "/", $className) . '.php';
//    echo $fileName . '  ';
    $file = __DIR__ . '/../../classes/' . $fileName;
    include $file;
}

spl_autoload_register('autoloader');