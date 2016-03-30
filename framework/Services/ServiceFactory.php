<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 07.03.2016
 * Time: 23:12
 */

namespace Framework\Services;

use Framework\Application;
use Framework\Exception\InvalidArgumentException;
use Framework\Exception\InvalidTypeException;
use Framework\DI\Service;

/**
 * Class ServiceFactory
 * @package Framework\Services
 */
abstract class ServiceFactory
{
    /**
     * Array of config parameters
     *
     * @var array
     */
    private static $config = array();

    /**
     * ServiceFactory constructor.
     */
    public function __construct()
    {
        //override protection
    }

    /**
     * Writes values into a variable and
     * return this variable
     *
     * @return array|mixed
     */
    public static function getConfig()
    {
        $config_map = include(Application::$config_map);
        self::$config = $config_map['service'];
        return self::$config;
    }

    /**
     * Create new object of current service
     * Write values in array of services
     * Always create new Security object
     *
     * @param $service_name
     * @return mixed
     * @throws InvalidArgumentException
     * @throws InvalidTypeException
     */
    public static function factory($service_name)
    {
        $service_data = self::getConfig()[$service_name];
        if(!empty($service_data))
        {
            $regexp = '~.*class.*~';
            foreach($service_data as $namespace => $path)
            {
                if(preg_match($regexp, $namespace))
                {
                    $object = new $path;
                    if($service_name == 'security')
                    {
                        return $object;
                    }
                    Service::set($service_name, $object);
                    return $object;
                }
            }
            throw new InvalidTypeException("There are no objects in service $service_name!");
        }
        else
        {
            throw new InvalidArgumentException("Service $service_name not found!");
        }
    }
}