<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 07.02.2016
 * Time: 23:00
 *
 * Router.php
 * PHP version 5
 */

namespace Framework\Router;

/**
 * Router.php
 */
class Router
{

    /**
     * Хранилище для массива routes
     *
     * @var array
     */
    protected static $map = array ();

    /**
     * Получает массив с параметрами
     *
     * Router constructor.
     * @param array $path_routes_map
     */
    public function __construct($path_routes_map = array())
    {
        self::$map = $path_routes_map;
        //echo "<pre>";
        //print_r(self::$map);
    }

    /**
     * Формирует пути к файлу контроллера используя url
     * Выбирает соответствующий action
     *     *
     * @param $url
     * @return $route_found
     */
    public function parseUrl($url)
    {
        $route_found = null;
        $string = null; // Additional condition in the choice of regular expression
        $url = str_replace('/web', '', $url); // если проблемы с редиректом

        foreach(self::$map as $route)
        {
            $pattern = $this -> preparePattern($route, $string = false);
            if(preg_match($pattern, $url, $params))
            {
                $pattern = $this -> preparePattern($route, $string = true);
                preg_match($pattern, str_replace(array('{','}'), '', $route['pattern']), $param_names);
                $params = array_combine($param_names, $params);
                array_shift($params); // Get rid of 0 element
                $route_found = $route;
                $route_found['params'] = $params;
                break;
            }
        }
        return $route_found;
    }

    /**
     * Формирует нужный url адрес
     *
     * @param $route_name
     * @param array $params
     * @return null|string
     */
    public function buildUrl($route_name, $params = array())
    {
        $url = null;

        $url = array_key_exists($route_name, self::$map) ? self::$map[$route_name]['pattern'] : '/';
        if(!empty($params))
        {
            foreach($params as $key => $value)
            {
                $url = str_replace('{'.$key.'}', $value, $url);
            }
        }
        // Подчищаем оставшиеся переменные, которые не были заменены
        $url = preg_replace('~\{[\w\d_]*\}~','',$url);
        return $url;
    }

    /**
     * Делает замену условия {id} на регулярное выражение
     *
     * @param $route
     * @return mixed|string
     */
    private function preparePattern($route, $string = false)
    {
        $pattern = null;

        if ($route['_requirements'] && $string == false)
        {
            foreach($route['_requirements'] as $key => $value)
            {
                $pattern = preg_replace('~\{'.$key.'\}~Ui',
                           '('.$route['_requirements'][$key].')', $route['pattern']);
                $route['pattern'] = $pattern;
            }
        }
        else
        {
            $pattern = preg_replace('~\{[\w\d_]+\}~Ui','([\w\d_]+)', $route['pattern']);
        }
        $pattern = '~^'.$pattern.'$~';
        //echo '<pre>';
        //print_r ($pattern);
        return $pattern;
    }
}