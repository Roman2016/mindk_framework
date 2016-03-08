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
        $fullpath = realpath(\Loader::get_path_views() . $layout);
        // Try to define renderer like a service. e.g.: Service::get('renderer');
        $renderer = new Renderer(Service::get('config')->get('main_layout'));
        $content = $renderer->render($fullpath, $data);
        return new Response($content);
    }

    /**
     * Redirect to another page
     *
     * @param $url
     * @return ResponseRedirect
     */
    public function redirect($url, $content = false)
    {
            return new ResponseRedirect($url, $content = false);
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
            $router = new Router();
            $url = $router -> buildUrl($key);
            return $url;
        }
        else
        {
            throw new InvalidArgumentException('Cannot generate url for empty key.');
        }
    }

    public function getRequest()
    {
        $request = null;
        return $this;
    }
}