<?php

/**
 * @param $class
 */
function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $path = explode('/',$path);
    unset($path[0]);
    $path = join('/',$path);
    $file = __DIR__.'/'.$path.'.php';
    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register('classLoader');