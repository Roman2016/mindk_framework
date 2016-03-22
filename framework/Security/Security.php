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

/**
 * Class Security
 * @package Framework\Security\Security
 */
class Security
{
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
            $this->token = password_hash($_SESSION['email'].'secret_code', PASSWORD_BCRYPT);
            $_SESSION['token'] = $this->token;
            setcookie('token', "$this->token", time()+300);
        }
        if($this->getRequest()->isGet())
        {
            // С каким значением сравнивать сгенерированный токен?
            if($_SESSION['token'] || $_COOKIE['token'])
            {

            }
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
    public  function clear()
    {
        session_unset();
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