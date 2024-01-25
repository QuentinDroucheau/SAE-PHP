<?php 

spl_autoload_register(static function(string $fqcn) {
    $path = str_replace('\\', '/', $fqcn).'.php';
    require_once('classes/'.$path);

});