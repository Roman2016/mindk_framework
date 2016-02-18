<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 15.02.2016
 * Time: 12:57
 */

namespace Framework\Response;

use Framework\Exception\InvalidArgumentException;

class ResponseRedirect extends \Framework\Response\Response
{
    /**
     * Параметры переадресации
     *
     * @var null
     */
    protected $targetUrl;

    /**
     * ResponseRedirect constructor.
     * @param string $url
     * @param array $content
     * @param string $type
     * @param int $code
     */
    public function __construct($url, $content = array(), $type = 'text/html', $code = 302)
    {
        if (empty($url)) {
            throw new InvalidArgumentException('Cannot redirect to an empty URL.');
        }

        parent::__construct($content, $type, $code);

        $this->setTargetUrl($url);
    }


    public function setTargetUrl($url)
    {
        $this->targetUrl = $url;

        $this->setHeader('Location', $url);
    }


    public function generateRoute($call_route)
    {

    }
    /**
     * Функция для отправки информации Headers и Body
     */
    public function send()
    {
        parent::send();
    }


    /**
     * Формирование массива для значений Headers
     *
     * @param $name
     * @param $value
     */
    public function setHeader($name, $value)
    {
        parent::setHeader($name, $value);
    }

    /**
     * Функция для отправки (отображения) параметров Headers
     */
    public function sendHeaders()
    {
        parent::sendHeaders();
    }

    /**
     * Функция для отправки (отображения) параметров Body
     */
    public function sendBody(){
        parent::sendBody();
    }
}