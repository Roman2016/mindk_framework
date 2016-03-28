<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 17.03.2016
 * Time: 17:07
 */

namespace Framework\Security;

use Framework\DI\Service;
use Framework\Request\Request;
use Framework\Response\ResponseRedirect;

/**
 * Class Security
 * @package Framework\Security\Security
 */
class Security
{
    /**
     * Value time existence for cookies in seconds
     */
    const TimeLiveCookies = 600;

    /**
     * User object
     *
     * @var null
     */
    private $object = null;

    /**
     * Token hashcode
     *
     * @var null
     */
    private $token = null;

    /**
     * Security constructor.
     */
    public function __construct()
    {
        $user_class = Service::get('config')->get('security');
        $this->object = new $user_class['user_class'];
        if($this->getRequest()->isPost())
        {
            $token = $this->getRequest()->post('token');
            if($token !== $_SESSION['token'] || $token !== $_COOKIE['token'])
            {
                Service::get('session')->addFlush('error', 'Careful, token of this page is not correct');
            }
        }
        if($this->getRequest()->isGet())
        {
            $this->token = password_hash($_SESSION['email'] . 'secret_code', PASSWORD_BCRYPT);
            setcookie('token', $this->token, time() + self::TimeLiveCookies);
            $_SESSION['token'] = $this->token;
        }
        //override protection
    }

    /**
     * Return request class
     *
     * @return Request
     */
    public function getRequest()
    {
        return new Request();
    }

    /**
     * Set value of user variables to session array
     *
     * @param $user
     */
    public function setUser($user)
    {
        $object_vars = get_object_vars($this->object);
        array_shift($object_vars);
        foreach ($user as $key => $value)
        {
            if (array_key_exists($key, $object_vars))
            {
                $_SESSION[$key] = $value;
            }
        }
    }

    /**
     * Unset all user session variables
     */
    public function clear()
    {
        $object_vars = get_object_vars($this->object);
        array_shift($object_vars);
        foreach ($object_vars as $key => $value)
        {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Return true if user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        if(isset($_SESSION['password']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}