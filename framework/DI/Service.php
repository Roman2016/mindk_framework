<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 31.01.2016
 * Time: 18:47
 */

namespace Framework\DI;

use Framework\Application;

/**
 * Class Service
 * @package Framework\DI
 */
class Service
{
    /**
     * Service constructor.
     */
    public function __construct()
    {

    }

    /**
     * Return appropriate config parameter
     *
     * @param $param
     * @return mixed
     */
    public static function get($param)
    {
        return Application::$config_map["$param"];
    }
}