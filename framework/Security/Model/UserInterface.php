<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 07.03.2016
 * Time: 22:42
 */

namespace Framework\Security\Model;

/**
 * Interface UserInterface
 * @package Framework\Security\Model
 */
interface UserInterface
{
    /**
     * Get the role of user
     *
     * @return mixed
     */
    public function getRole();
}