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
        self::$someNamePath[$namespace] = $path;
    }

    public static function returnNamespacePath()
    {
        //print_r (self::$someNamePath);
        return self::$someNamePath;
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
        foreach(self::$someNamePath as $namespace => $path)
        {
            $regexp = '~^'.$namespace.'.*~';
            if(preg_match($regexp, $classname))
            {
                $pathclass = str_replace($namespace, '', $classname);
                $pathFile = str_replace('\\', '/', $pathclass);
                $pathFull = $path.'/'.$pathFile.'.php';
                if (file_exists($pathFull))
                {
                    include_once($pathFull);
                }
                break;
            }
        }
    }
}

Loader::getInstance();