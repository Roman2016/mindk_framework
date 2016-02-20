<?php
/**
 * Response.php
 *
 * PHP version 5
 *
 * Created by PhpStorm.
 * User: Users CS
 * Date: 15.02.2016
 * Time: 12:45
 */

namespace Framework\Response;

/**
 * Class Response
 * @package Framework\Response
 */
class Response
{
    /**
     * Массив для значений Headers
     *
     * @var array
     */
    protected $headers = array();

    /**
     * Код состояния
     *
     * @var int
     */
    public $code = 200;

    /**
     * Передаваемый контент
     *
     * @var string
     */
    public $content = '';

    /**
     * Тип данных
     *
     * @var string
     */
    public $type = 'text/html';

    /**
     * Хранилище кодов состояния
     *
     * @var array
     */
    protected static $msgs = array(
        200 => 'Ok',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily',
        404 => 'Not found',
        500 => 'Internal Server Error'
    );

    /**
     * Response constructor.
     * @param string $content
     * @param string $type
     * @param int $code
     */
    public function __construct($content = '', $type = 'text/html', $code = 200)
    {
        $this->code = $code;
        $this->content = $content;
        $this->type = $type;
        $this->setHeader('Content-Type', $this->type);
    }

    /**
     * Функция для отправки информации Headers и Body
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendBody();
    }


    /**
     * Формирование массива для значений Headers
     *
     * @param $name
     * @param $value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Функция для отправки (отображения) параметров Headers
     */
    public function sendHeaders()
    {
        header($_SERVER['SERVER_PROTOCOL'].' '.$this->code.' '.self::$msgs[$this->code]);
        foreach($this->headers as $key => $value){
            header(sprintf("%s: %s", $key, $value));
        }
    }

    /**
     * Функция для отправки (отображения) параметров Body
     */
    public function sendBody()
    {
        echo $this->content;
    }
}