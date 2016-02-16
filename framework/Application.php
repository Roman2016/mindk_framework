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
use Framework\Response\Response;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\BadResponseTypeException;
use Framework\Exception\AuthRequredException;

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
        $response = null;

        $router = new Router(include('../app/config/routes.php'));

        $route = $router -> parseUrl(trim(strip_tags($_SERVER['REQUEST_URI'])));

        try
        {
            if(!empty($route))
            {
                $controllerReflection = new \ReflectionClass($route['controller']);
                $action = $route['action'] . 'Action';
                if($controllerReflection->hasMethod($action))
                {
                    $controller = $controllerReflection->newInstance();
                    //echo '<pre>';
                    //print_r($controller);
                    $actionReflection = $controllerReflection->getMethod($action);
                    //echo '<pre>';
                    //print_r($actionReflection);
                    $response = $actionReflection->invokeArgs($controller, $route['params']);
                    //echo '<pre>';
                    //print_r($response);
                    if($response instanceof Response)
                    {
                        //$response->send();
                        // ...
                    }
                    else
                    {
                        throw new BadResponseTypeException('Missing type of response');
                    }
                }
            }
            else
            {
                throw new HttpNotFoundException('Route not found');
            }
        }
        catch(HttpNotFoundException $e)
        {
            // Render 404 or just show msg
        }
        catch(AuthRequredException $e)
        {
            // Reroute to login page
            //$response = new RedirectResponse(...);
        }
        catch(BadResponseTypeException $e)
        {
            echo $e->getMessage();
        }
        catch(\Exception $e)
        {
            // Do 500 layout...
            echo $e->getMessage();
        }

        $response->send();

        $buildUrl = $router -> buildUrl('show_post', $params = array("id" => 10));

        //echo '<pre>';
        //print_r($buildUrl);
        //echo '<pre>';
        //print_r($route);

    }
}