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
     * @var array
     */
    protected $headers = array();

    /**
     * @var int
     */
    public $code = 200;

    /**
     * @var string
     */
    public $content = array();

    /**
     * @var string
     */
    public $type = 'text/html';

    /**
     * @var array
     */
    private static $msgs = array(
        200 => 'Ok',
        404 => 'Not found'
    );

    /**
     * Response constructor.
     * @param string $content
     * @param string $type
     * @param int $code
     */
    public function __construct($content = array())
    {
        //$this->code = $code;
        $this->content = $content;
        //$this->type = $type;
        $this->setHeader('Content-Type', $this->type);
    }

    /**
     *
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendBody();
    }


    /**
     * @param $name
     * @param $value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     *
     */
    public function sendHeaders()
    {
        header($_SERVER['SERVER_PROTOCOL'].' '.$this->code.' '.self::$msgs[$this->code]);
        foreach($this->headers as $key => $value){
            header(sprintf("%s: %s", $key, $value));
        }
    }

    /**
     *
     */
    public function sendBody(){
        echo json_encode($this->content);
    }
}