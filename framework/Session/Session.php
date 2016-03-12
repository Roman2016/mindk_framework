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
    public $messages = [];

    public function __construct()
    {
        session_start();
    }

    public function __set($name, $val)
    {

    }

    public function __get($name)
    {

    }

    public function addFlash($type, $message)
    {
        $_SESSION['messages'][$type][] = $message;
    }
}