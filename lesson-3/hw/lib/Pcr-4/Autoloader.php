<?php
namespace Pcr;

/**
 * Class Autoloader include classes dynamically
 *
 * @package Pcr
 */
class Autoloader
{
    private static $instance;

    /**
     * @return Autoloader
     */
    private static function instance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Autoloader();
        }

        return self::$instance;
    }

    /**
     * Register an autoloader
     */
    public static function init()
    {
        spl_autoload_register(array(self::instance(), 'autoload'));
    }

    /**
     * Include declared class
     *
     * @param $class
     * @return mixed
     */
    private function autoload($class)
    {
        $className = ltrim($class, '\\');
        $fileName  = '';
        $namespace = '';

        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        return include $fileName;
    }
}