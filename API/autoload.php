<?php

spl_autoload_register(function ($classname) {
    
    $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
    $file = str_replace('MyTest', 'src', $classname);
    
    $file .= '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});