<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 12.03.2016
 * Time: 14:37
 */

namespace Framework\Session;

use Blog\Controller\SecurityController;

/**
 * Class Session
 * @package Framework\Session
 */
class Session
{
    /**
     * @var
     */
    public $returnUrl;

    /**
     * Secret code to check session
     *
     * @var string
     */
    private $fingerprint;

    /**
     * Start session, cookie
     * Generate secret fingerprint
     * Check user for current session
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
            if (password_verify(($this->fingerprint), $_SESSION['HTTP_USER_AGENT']))
            {
                session_unset();
                session_destroy();
                $errors = array();
                array_push($errors, "Current session was destroyed, please reconnect");
                $controller = new SecurityController();
                return $controller->render('login.html', array('errors' => $errors));
            }
            $this->returnUrl = trim(strip_tags($_SERVER['REQUEST_URI']));
        }
        else
        {
            session_start();
            $_SESSION['HTTP_USER_AGENT'] = password_hash(md5($_SESSION['HTTP_USER_AGENT']), PASSWORD_BCRYPT);
            $this->fingerprint = 'fingerprint' . $_SERVER['HTTP_USER_AGENT'] . session_id();
            $_SESSION['HTTP_USER_AGENT'] = password_hash(($this->fingerprint), PASSWORD_BCRYPT);
            $this->returnUrl = trim(strip_tags($_SERVER['REQUEST_URI']));
        }
    }

    /**
     *
     *
     * @return \Framework\Response\Response
     */
    public function control()
    {
        if (isset($_SESSION['HTTP_USER_AGENT']))
        {
            if (!password_verify(($this->fingerprint), $_SESSION['HTTP_USER_AGENT']))
            {
                session_unset();
                session_destroy();
                $errors = array();
                array_push($errors, "Current session was destroyed, please reconnect");
                $controller = new SecurityController();
                return $controller->render('login.html', array('errors' => $errors));
            }
        }
        else
        {
            session_start();
            $_SESSION['HTTP_USER_AGENT'] = password_hash(md5($_SESSION['HTTP_USER_AGENT']), PASSWORD_BCRYPT);
            $this->fingerprint = 'fingerprint' . $_SERVER['HTTP_USER_AGENT'] . session_id();
            $_SESSION['HTTP_USER_AGENT'] = password_hash(($this->fingerprint), PASSWORD_BCRYPT);
            $this->returnUrl = trim(strip_tags($_SERVER['REQUEST_URI']));
        }
    }

    public function getUrl()
    {
        $this->returnUrl = trim(strip_tags($_SERVER['REQUEST_URI']));
    }

    /**
     * Set new URL parameter
     *
     * @param $name
     * @param $val
     */
    public function __set($name, $val)
    {
        $this->name = $val;
    }

    /**
     * Get parameters from private variables
     *
     * @param $name
     */
    public function __get($name)
    {
        return $name;
    }

    /**
     * Add messages to session array
     *
     * @param $type
     * @param $message
     */
    public function addFlash($type, $message)
    {
        $_SESSION['messages'][$type][] = $message;
    }
}