<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 08.03.2016
 * Time: 14:34
 */

namespace Framework\Services;

use Framework\Application;
use Framework\Exception\InvalidArgumentException;

/**
 * Class Config
 * @package Framework\Services\Config
 */
class Config
{
    /**
     * Array of config parameters
     *
     * @var array|mixed
     */
    public $config = array();

    /**
     * Writes values into a variable
     *
     * Config constructor.
     */
    public function __construct()
    {
        $this->config = include(Application::$config_map);
    }

    /**
     * Return value of current config options
     *
     * @param $service_name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get($service_name)
    {
        if(!empty($this->config[$service_name]))
        {
            //$service = str_replace('__DIR__.\'/../', '', $this->config[$service_name]);
            $service = $this->config[$service_name];
            return $service;
        }
        else
        {
            throw new InvalidArgumentException("Service $service_name not found!");
        }
    }
}