<?php
spl_autoload_register(function ($classname) {
    $level1 = explode("\\", $classname);
    $level2 = implode('/', $level1);
    $location = __DIR__ . DIRECTORY_SEPARATOR . $level2 . '.php';
    if (file_exists($location)) {
        require_once $location;
    } else {
        die('Error : can not find class');
    }
});

?>