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
     * Хранилище для обьекта класса
     *
     * @var null
     */
    private static $instance = null;

    /**
     * Хранит пути к файлам
     *
     * @var array
     */
    private static $someNamePath = array();

    /**
     * Реализовывает паттерн singleton
     * существует только один обьект класса Loader
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
     * Регистрирует автозагрузчик
     *
     * Loader constructor.
     */
    private function __construct()
    {
        //override protection
        spl_autoload_register(array(__CLASS__, 'LoadFile'));
    }

    /**
     * Защищает обьект от клонирования
     */
    private function __clone()
    {
        //override protection
    }

    /**
     * Записывает полученные пути и пространства имен в
     * ассоциативный массив
     *
     * @param $namespace
     * @param $path
     */
    public static function addNamespacePath($namespace, $path)
    {
        self::$someNamePath[$namespace] = $path;
    }

    /**
     * Возвращает массив путей к файлам
     *
     * @return array
     */
    public static function returnNamespacePath()
    {
        //print_r (self::$someNamePath);
        return self::$someNamePath;
    }

    /**
     * Формирует полный путь к файлам и подключает их
     *
     * Может существовать только один одноименный подключенный файл
     * При отсутствии файла ошибки не будет
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