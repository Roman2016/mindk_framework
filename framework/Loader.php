<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 31.01.2016
 * Time: 16:59
 *
 * Loader.php
 * PHP version 5
 */

/**
 * Class Loader
 */
class Loader
{
    /**
     * Repository for class object
     *
     * @var null
     */
    private static $instance = null;

    /**
     * Associative array of files paths
     *
     * @var array
     */
    private static $someNamePath = array();

    /**
     * Stores namespace
     *
     * @var null
     */
    private static $NameSpace = null;

    /**
     * Stores name of controller
     *
     * @var null
     */
    private static $ControllerName = null;

    /**
     * Implement pattern singleton
     * There is only one object of class Loader
     *
     * @return Loader|null
     */
    public static function getInstance()
    {
        if (empty(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Autoloader log
     *
     * Loader constructor.
     */
    private function __construct()
    {
        //override protection
        spl_autoload_register(array(__CLASS__, 'LoadFile'));
    }

    /**
     * Protect object from cloning
     */
    private function __clone()
    {
        //override protection
    }

    /**
     * Save received paths and namespaces
     * in associative array
     *
     * @param $namespace
     * @param $path
     */
    public static function addNamespacePath($namespace, $path)
    {
        self::$someNamePath[$namespace] = $path;
        self::$NameSpace = $namespace;
    }

    /**
     * Return array of files paths
     *
     * @return array
     */
    public static function returnNamespacePath()
    {
        return self::$someNamePath;
    }

    /**
     * Generates full path to file html
     *
     * @return string
     */
    public static function get_path_views()
    {
        $folder_path = self::$someNamePath[self::$NameSpace];
        $view_name = str_replace('Controller', '', self::$ControllerName);
        $fullPath = $folder_path.'/views'.$view_name.'/';
        return $fullPath;
    }

    /**
     * Generates full path to files and connect them
     *
     * Exists only one file with the same name
     * There is no error if file does not exists
     *
     * @param $classname
     * @return void
     */
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
                // Controller class name for path to views
                $regexp = '~^Controller.*~';
                if(preg_match($regexp, $pathFile))
                {
                    self::$ControllerName = $pathFile;
                }
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

