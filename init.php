<?php
class Loader {
    public static function loadClass(string $class) {
        $file_prefix = str_replace('\\', '/', $class);
        require_once($file_prefix . '.php');
    }
}

spl_autoload_register(['Loader', 'loadClass']);
