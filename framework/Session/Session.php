<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 12.03.2016
 * Time: 14:37
 */

namespace Framework\Session;

/**
 * Class Session
 * @package Framework\Session
 */
class Session
{
    /**
     *
     *
     * @var array
     */
    public $messages = [];

    /**
     * @var
     */
    public $returnUrl;

    /**
     * @var string
     */
    private $fingerprint;

    /**
     *
     *
     * Session constructor.
     */
    public function __construct()
    {
        //ini_set('display_errors', 1);
        //error_reporting(E_ALL);
        setcookie('on','1');
        if (isset($_SESSION['HTTP_USER_AGENT']))
        {
            if ($_SESSION['HTTP_USER_AGENT'] != md5($this->fingerprint))
            {
                session_destroy();
                exit("Current session was destroyed, please reconnect");
            }
        }
        else
        {
            session_start();
            $_SESSION['HTTP_USER_AGENT'] = md5($_SESSION['HTTP_USER_AGENT']);
            $this->fingerprint = 'fingerprint' . $_SERVER['HTTP_USER_AGENT'] . session_id();
            $_SESSION['HTTP_USER_AGENT'] = md5($this->fingerprint);
        }
    }

    /**
     *
     *
     * @param $name
     * @param $val
     */
    public function __set($name, $val)
    {

    }

    /**
     *
     *
     * @param $name
     */
    public function __get($name)
    {

    }

    /**
     *
     *
     * @param $type
     * @param $message
     */
    public function addFlash($type, $message)
    {
        $_SESSION['messages'][$type][] = $message;
    }
}