<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 15.02.2016
 * Time: 12:59
 */

namespace Framework\Response;

class JsonResponse extends \Framework\Response\Response
{
    /**
     * Передаваемый контент
     *
     * @var string
     */
    public $content = array();

    /**
     * JsonResponse constructor.
     * @param array $content
     * @param string $type
     * @param int $code
     */
    public function __construct($content = array(), $type = 'text/html', $code = 200)
    {
        parent::__construct($content, $type, $code);
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
        echo json_encode($this->content);
    }
}