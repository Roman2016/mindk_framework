<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 29.02.2016
 * Time: 12:55
 */

namespace Framework\Model;

use Framework\DI\Service;

abstract class ActiveRecord
{
    /**
     * Parameters of database connection
     *
     * @var null
     */
    public static $pdo = null;

    /**
     * Return data validation rules
     *
     * @return array
     */
    public function getRules()
    {
        return [];
    }

    /**
     * Receive object with parameters of database connection
     *
     * @return null
     */
    public static function getDBCon()
    {
        if(empty(self::$pdo))
        {
            self::$pdo = Service::get('db')->getDB();
        }
        return self::$pdo;
    }

    /**
     * Get the name of table
     *
     * @return mixed
     */
    //abstract public static function getTable();

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
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    /**
     * Return array variables of this class
     *
     * @return array
     */
    protected function getFields()
    {
        return get_object_vars($this);
    }

    /**
     * Save data into current table
     *
     * Get array variables of this class and
     * parameters of database connection
     *
     * Create query that depends from class variables
     */
    public function save()
    {
        $fields = $this->getFields();
        array_shift($fields);
        $table = static::getTable();
        $key_mas = array();

        foreach($fields as $key => $value)
        {
            $key_mas[] = $key;
        }
        $sql_query = "INSERT INTO " .$table. " (";;
        $sql_data = "(";
        for($i = 0; $i<count($fields); $i++)
        {
            if($i == count($fields)-1)
            {
                $sql_query = $sql_query.$key_mas[$i].") VALUES ";
                $sql_data = $sql_data.' :'.$key_mas[$i].")";
            }
            else
            {
                $sql_query = $sql_query .$key_mas[$i]. ", ";
                $sql_data = $sql_data.' :'.$key_mas[$i]. ", ";
            }
        }
        $sql = $sql_query . $sql_data;
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($fields);
    }

    /**
     * Delete data from current row of table
     */
    public function delete()
    {

    }

    /**
     * Change data of current table
     */
    public function updateData()
    {

    }
}