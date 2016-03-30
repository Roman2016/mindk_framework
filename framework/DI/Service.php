<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 31.01.2016
 * Time: 18:47
 */

namespace Framework\DI;

use Framework\Application;
use Framework\Services\ServiceFactory;

/**
 * Class Service
 * @package Framework\DI
 */
class Service
{
    /**
     * Array of services
     *
     * @var array
     */
    protected static $services = array();

    /**
     * Service constructor.
     */
    public function __construct()
    {
        //override protection
    }

    /**
     * Write values in array of services
     *
     * @param $service_name
     * @param $obj
     */
    public static function set($service_name, $obj)
    {
        self::$services[$service_name] = $obj;
    }

    /**
     * Return current service object
     *
     * @param $service_name
     * @return null
     */
    public static function get($service_name)
    {
        return empty(self::$services[$service_name]) ? ServiceFactory::factory($service_name)
                                                     : self::$services[$service_name];
    }
}