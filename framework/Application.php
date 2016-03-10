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
use Framework\Response\ResponseRedirect;
use Framework\Controller\Controller;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\BadResponseTypeException;
use Framework\Exception\AuthRequredException;
use Framework\Exception\BadControllerTypeException;
use Framework\Exception\InvalidArgumentException;
use Framework\DI\Service;


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
     *
     * Проверяет, используя рефлексию, наличие нужного класса
     * контроллера и методов в нем
     *
     * Создает соответствующий класс Response
     */
    public function run()
    {
        $response = null;

        $router = new Router(include('../app/config/routes.php'));

        $route = $router -> parseUrl(trim(strip_tags($_SERVER['REQUEST_URI'])));

        //echo '<pre>';
        //include(\Framework\Services\ServiceFactory::factory('config')->get('main_layout'));
        //echo '</pre>';

        try
        {
            if(!empty($route))
            {
                $controllerReflection = new \ReflectionClass($route['controller']);
                $action = $route['action'] . 'Action';
                if($controllerReflection->hasMethod($action))
                {
                    // Проверка ролей юзера
                    $controller = $controllerReflection->newInstance();
                    if($controller instanceof Controller)
                    {
                        $actionReflection = $controllerReflection->getMethod($action);
                        $response = $actionReflection->invokeArgs($controller, $route['params']);
                        if ($response instanceof Response)
                        {
                            // ...
                            //include('../src/Blog/views/layout.html.php');
                        }
                        else
                        {
                            throw new BadResponseTypeException('Missing type of response');
                        }
                    }
                    else
                    {
                        throw new BadControllerTypeException('Missing type of controller');
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
            $error = $e->getMessage();
            include(Service::get('config')->get('error_404'));
        }
        catch(AuthRequredException $e)
        {
            // Reroute to login page
            $response = new ResponseRedirect("/login");
            $response->sendHeaders();
        }
        catch(InvalidArgumentException $e)
        {
            echo $e->getMessage();
        }
        catch(BadResponseTypeException $e)
        {
            echo $e->getMessage();
        }
        catch(\Exception $e)
        {
            // Do 500 layout...
            include(Service::get('config')->get('error_500'));
            //echo $e->getMessage();
            //echo '<script>location.replace("_URL_");</script>'; exit;
        }

        $response->send();
    }
}