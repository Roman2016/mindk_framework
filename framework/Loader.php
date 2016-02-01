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
    private static $someNamePath = array();
    private static $NameSpace = null;
    private static $Path = null;

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
        self::$Path = $path;

        for ($i = 0; $i < count(self::$someNamePath); $i++)
        {
            if (key(self::$someNamePath) == $namespace)
            {
                if (self::$someNamePath[$namespace] == $path)
                {
                    return;
                    //return self::$someNamePath[$namespace];
                }
            }
        }
        self::$someNamePath[$namespace] = $path;
        //return self::$someNamePath[$namespace];
    }

    public static function returnNamespacePath()
    {
        print_r (self::$someNamePath);
        return self::$NameSpace;
    }

    public static function LoadFile($classname)
    {
        $pathclass = str_replace('Framework', '', $classname);
        $pathFile = str_replace('\\', '/', $pathclass);
        $pathFull = __DIR__.$pathFile.'.php';
        if (file_exists($pathFull))
        {
            include_once($pathFull);
        }
        $pathclass = str_replace(self::$NameSpace, '', $classname);
        $pathFile = str_replace('\\', '/', $pathclass);
        $pathFull =self::$Path.'/'.$pathFile.'.php';
        if (file_exists($pathFull))
        {
            include_once($pathFull);
        }
    }
}

Loader::getInstance();