<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 17.03.2016
 * Time: 17:07
 */

namespace Framework\Security;

use Framework\DI\Service;

/**
 * Class Security
 * @package Framework\Security\Security
 */
class Security
{
    /**
     * @var null
     */
    private $object = null;

    /**
     * Security constructor.
     */
    public function __construct()
    {
        $user_class = Service::get('config')->get('security');
        $this->object = new $user_class['user_class'];
        //override protection
    }

    public function setUser($user)
    {
        $object_vars = get_object_vars($this->object);
        foreach ($user as $key => $value)
        {
            if (array_key_exists($key, $object_vars))
            {

            }
        }
    }

    public  function clear()
    {

    }

    public function isAuthenticated()
    {

    }
}