<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 17.03.2016
 * Time: 17:12
 */

return array(
    'security'    => array(
        'user_class'    =>  'Framework\\Security\\Security'
    ),
    'session'     => array(
        'session_class' =>  'Framework\\Session\\Session'
    ),
    'config'      => array(
        'config_class'  =>  'Framework\\Services\\Config'
    ),
    'db'          => array(
        'db_class'      =>  'Framework\\Services\\DB'
    ),
    'event'       => array(
        'events_class'  =>  'Framework\\Services\\Event'
    )
);