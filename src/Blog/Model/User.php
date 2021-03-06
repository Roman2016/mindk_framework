<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:09 PM
 */

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Security\Model\UserInterface;

class User extends ActiveRecord implements UserInterface
{
    public $id;
    public $email;
    public $password;
    public $role;

    public static function getTable()
    {
        return 'users';
    }

    public function getRole()
    {
        return $this->role;
    }

    public static function getThisClass()
    {
        return __CLASS__;
    }

    public static function findByEmail($email)
    {
        $table = self::getTable();
        if(!empty($email))
        {
            $sql = "SELECT * FROM " . $table . " WHERE email= :email";
        }
        else
        {
            return null;
        }
        $stmt = static::$pdo->prepare($sql);
        $stmt->execute(array('email' => $email));
        $result = $stmt->fetch();
        return $result;
    }
}