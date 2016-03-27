<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 29.02.2016
 * Time: 11:52
 */

namespace Framework\Renderer;

use Blog\Controller\PostController;
use Framework\Controller\Controller;
use Framework\Router\Router;
use Framework\Exception\HttpNotFoundException;
use Framework\DI\Service;
use Blog\Model\User;

/**
 * Class Renderer
 *
 * @package Framework\Renderer
 */
class Renderer
{
    /**
     * @var string  Main wrapper template file location
     */
    protected $main_template = '';

    /**
     * Class instance constructor
     *
     * @param $main_template_file
     */
    public function __construct($main_template_file)
    {
        $this->main_template = $main_template_file;
        //echo $this->main_template;
    }

    /**
     * Render main template with specified content
     *
     * @param $content
     *
     * @return html/text
     */
    public function renderMain($content)
    {
        return $this->render($this->main_template, compact('content'), false);
    }

    public function renderMainMy()
    {
        return $this->main_template;
    }

    /**
     * Render specified template file with data provided
     *
     * @param   string  $template file path (full)
     * @param   mixed   $data array
     * @param   bool    to be wrapped with main template if true
     *
     * @throws HttpNotFoundException
     *
     * @return  text/html
     */
    public function render($template_path, $data = array(), $wrap = true)
    {
        extract($data);

        ob_start();

        $include = function($controller, $action, $data)
        {
            $controller = new $controller;
            $method = $action.'Action';
            extract($data);
            return $result = $controller->$method($id);
        };
        $getRoute = function($key)
        {
            $controller = 'Blog\\Controller\\TestController';
            $controller = new $controller;
            return $controller->generateRoute($key);
        };

        if(Service::get('security')->isAuthenticated())
        {
            $user = new User();
            $user->email = $_SESSION['email'];
        }
        else
        {
            $user = null;
        }
        if(!empty($_SESSION['messages']))
        {
            $flush = $_SESSION['messages'];
        }
        /*
        $generateToken = function()
        {
            $token = '11111111';
            $token = '<input type="hidden" name="token" value="' . $token . '">';
            return $token;
        };
        */
        if(file_exists($template_path)) // Проверка на наличие файла по заданному адресу
        {
            include($template_path);
        }
        else
        {
            throw new HttpNotFoundException('Route to HTML not found');
        }
        $content = ob_get_contents();
        if($wrap)
        {
            $content = $this->renderMain($content);
        }
        unset($_SESSION['messages']);
        ob_end_clean();
        //echo '<pre>';
        //print_r($content);
        //echo '</pre>';
        return $content;
    }
}