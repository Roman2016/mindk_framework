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
use Framework\Exception\BadPathTypeException; // Нужно выбрасывать исключение если нет файла?

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
        $this -> main_template = $main_template_file;
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
        //@TODO: set all required vars and closures...
        /** Some required vars or closures...
        $activeIfRoute('home');
        $getRoute('home');
        */
        return $this -> render($this->main_template, compact('content'), false);
    }

    /**
     * Render specified template file with data provided
     *
     * @param   string  $template file path (full)
     * @param   mixed   $data array
     * @param   bool    to be wrapped with main template if true
     *
     * @return  text/html
     */
    public function render($template_path, $data = array(), $wrap = true)
    {
        extract($data);
        // @TODO: provide all required vars or closures...
        ob_start();
        if(file_exists($template_path)) // Проверка на наличие файла по заданному адресу
        {
            include($template_path);
        }
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
        /** Some required vars or closures...
        $getValidationClass('title');
        $getErrorBody('title');
        $generateToken();
        */
        $content = ob_end_clean();
        if($wrap)
        {
            $content = $this -> renderMain($content);
        }
        return $content;
    }
}