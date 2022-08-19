<?php
spl_autoload_register(function($class) {
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(strpos($url, 'dashboard') !== false){
        $path = '../classes/';
    } else {
        $path = 'classes/';
    }
    $extension = '.class.php';
    require $path . $class . $extension;
});