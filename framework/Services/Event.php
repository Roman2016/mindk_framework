<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 28.03.2016
 * Time: 22:55
 */

namespace Framework\Services;

use Framework\Application;
use Framework\Model\ActiveRecord;

/**
 * Class Event
 * @package Framework\Services
 */
class Event
{
    private $events = array();

    public function __construct()
    {
        $events = include(Application::$config_map);
        $this->events = $events['events'];
    }

    public function trigger($parameter)
    {
        return $this->events[$parameter];
    }
}