<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 31.01.2016
 * Time: 16:59
 */

class Loader
{
    private static $instance = null;
    private static $NameSpace;
    private static $someNamePath;

    public static function getInstance()
    {
        if (empty(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        //override protection
        spl_autoload_register(array(__CLASS__, 'LoadFile'));
    }

    private function __clone()
    {
        //override protection
    }

    public static function addNamespacePath($namespace, $path)
    {
        self::$NameSpace = $namespace;
        self::$someNamePath = $path;
    }

    public static function LoadFile($classname)
    {
        $pathclass = str_replace('Framework', '', $classname);
        $pathFile = str_replace('\\', '/', $pathclass);
        $path = __DIR__.$pathFile.'.php';
        if (file_exists($path))
        {
            include_once($path);
        }
        $pathclass = str_replace(self::$NameSpace, '', $classname);
        $pathFile = str_replace('\\', '/', $pathclass);
        $path =self::$someNamePath.'/'.$pathFile.'.php';
        if (file_exists($path))
        {
            include_once($path);
        }
    }
}

Loader::getInstance();