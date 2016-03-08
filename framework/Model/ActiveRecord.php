<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 29.02.2016
 * Time: 12:55
 */

namespace Framework\Model;

use Framework\DI\Service;
//use Blog\Model\User;

abstract class ActiveRecord
{
    /**
     * Parameters of database connection
     *
     * @var null
     */
    protected static $db = null;

    /**
     * Class constructor
     */
    public function __construct()
    {
        //override protection
    }

    /**
     * Receive object with parameters of database connection
     *
     * @return null
     */
    public static function getDBCon()
    {
        if(empty(self::$db))
        {
            self::$db = Service::get('db');
        }
        return self::$db;
    }

    /**
     * Get the name of table
     *
     * @return mixed
     */
    abstract public static function getTable();

    /**
     * Perform select data from current table
     *
     * @param string $mode
     * @return mixed
     */
    public static function find($mode = 'all')
    {
        $table = static::getTable();
        $sql = "SELECT * FROM " . $table;
        if(is_numeric($mode))
        {
            $sql .= " WHERE id=".(int)$mode;
        }
        // PDO request...
        return $result;
    }

    public static function findByEmail($email)
    {
        return $result;
    }

    /**
     *
     *
     * @return array
     */
    protected function getFields()
    {
        return get_object_vars($this);
    }

    /**
     * Save data into current table
     */
    public function save()
    {
        $fields = $this->getFields();
        // @TODO: build SQL expression, execute
    }

    /**
     * Delete data from current table
     */
    public function delete()
    {

    }

    /**
     * Change data of current table
     */
    public function changeData()
    {

    }
}