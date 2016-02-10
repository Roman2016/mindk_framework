<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 31.01.2016
 * Time: 17:19
 *
 * Application.php
 * PHP version 5
 */

namespace Framework;

use Framework\Router\Router;

/**
 * Class Application
 * @package Framework
 */
class Application
{
    /**
     * @var array
     */
    public static $config_map = array();

    /**
     * Application constructor.
     * @param array $config_path
     */
    public function __construct($config_path = array())
    {
        self::$config_map = $config_path;
        //override protection
    }

    /**
     * Создает класс роутера и вызывает функцию, которая
     * обрабатывает входящий url адрес
     */
    public function run()
    {
        $router = new Router(include('../app/config/routes.php'));

        $route = $router -> parseUrl(trim(strip_tags($_SERVER['REQUEST_URI'])));

        if(!empty($route))
        {

        }
        else
        {

        }

        $buildUrl = $router -> buildUrl('profile', $params = array("id" => 1));

        echo '<pre>';
        print_r($buildUrl);
        echo '<pre>';
        print_r($route);
    }
}