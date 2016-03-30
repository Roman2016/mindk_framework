<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 02.02.2016
 * Time: 16:05
 */

namespace Framework\Controller;

use Framework\Router\Router;
use Framework\Response\Response;
use Framework\Renderer\Renderer;
use Framework\Response\ResponseRedirect;
use Framework\DI\Service;
use Framework\Exception\InvalidArgumentException;
use Framework\Request\Request;

/**
 * Class Controller
 * @package Framework\Controller
 */
abstract class Controller
{
    /**
     * Rendering method
     *
     * @param   string  $layout file name
     * @param   mixed   $data
     *
     * @return  Response
     */
    public function render($layout, $data = array())
    {
        $fullpath = realpath(\Loader::get_path_views() . $layout . '.php');
        $renderer = new Renderer(realpath(Service::get('config')->get('main_layout')));
        $content = $renderer->render($fullpath, $data);
        return new Response($content);
    }

    /**
     * Redirect to another page
     *
     * @param $url
     * @return ResponseRedirect
     */
    public function redirect($url, $message = false)
    {
        if(!empty($message))
        {
            Service::get('session')->addFlush('error', $message);
        }
        return new ResponseRedirect($url);
    }

    /**
     * Generate a full URL for a given key parameter
     *
     * @param $key
     * @return null|string|void
     * @throws InvalidArgumentException
     */
    public function generateRoute($key)
    {
        if(!empty($key))
        {
            $router = new Router(Service::get('config')->get('routes'));
            $url = $router->buildUrl($key);
            return $url;
        }
        else
        {
            throw new InvalidArgumentException('Cannot generate url for empty key.');
        }
    }

    /**
     * Return request class
     *
     * @return Request
     */
    public function getRequest()
    {
        return new Request();
    }
}