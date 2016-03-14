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
     *
     *
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
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