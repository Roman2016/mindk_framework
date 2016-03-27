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
        if (isset($_SESSION['HTTP_USER_AGENT']))
        {
            if (!password_verify(($this->fingerprint), $_SESSION['HTTP_USER_AGENT']))
            {
                session_unset();
                session_destroy();
                return true;
            }
            if(!empty($_SESSION['lastUrl']) && trim(strip_tags($_SERVER['REQUEST_URI']) == '/web/login'))
            {
                $this->returnUrl = $_SESSION['lastUrl'];
                unset($_SESSION['lastUrl']);
            }
        }
        else
        {
            //ini_set('display_errors', 1);
            //error_reporting(E_ALL);
            setcookie('on','1');
            session_start();
            $_SESSION['HTTP_USER_AGENT'] = password_hash(md5($_SESSION['HTTP_USER_AGENT']), PASSWORD_BCRYPT);
            $this->fingerprint = 'fingerprint' . $_SERVER['HTTP_USER_AGENT'] . session_id();
            $_SESSION['HTTP_USER_AGENT'] = password_hash(($this->fingerprint), PASSWORD_BCRYPT);
        }
    }

    public function getUrl()
    {
        $_SESSION['lastUrl'] = trim(strip_tags($_SERVER['REQUEST_URI']));
    }

    /**
     * Set new parameter
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
    public function addFlush($type, $message)
    {
        $_SESSION['messages'][$type][] = $message;
    }
}