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
     * Array for Headers
     *
     * @var array
     */
    protected $headers = array();

    /**
     * Page status code
     *
     * @var int
     */
    public $code = 200;

    /**
     * HTML content
     *
     * @var string
     */
    public $content = '';

    /**
     * Data type
     *
     * @var string
     */
    public $type = 'text/html';

    /**
     * Repository for status codes
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
     * Send Headers and Body information
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendBody();
    }


    /**
     * Create array for Headers information
     *
     * @param $name
     * @param $value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Send Headers parameters to html
     */
    public function sendHeaders()
    {
        header($_SERVER['SERVER_PROTOCOL'].' '.$this->code.' '.self::$msgs[$this->code]);
        foreach($this->headers as $key => $value){
            header(sprintf("%s: %s", $key, $value));
        }
    }

    /**
     * Send content to html Body
     */
    public function sendBody()
    {
        echo $this->content;
    }
}