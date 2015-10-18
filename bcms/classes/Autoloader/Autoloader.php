<?php
/*
 * Autoloader.php - автозагрузчик классов
 */
namespace classes\Autoloader;

class Autoloader {

    private static $LastLoadedFilename;

    public static function autoload($className) {
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = \substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if ($fileName !== false) {
            require $_SERVER['DOCUMENT_ROOT'] . '/' . $fileName;
        }
    }

}
