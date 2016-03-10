<?php

return array(
    'mode'        => 'dev',
    'routes'      => include('routes.php'),
    'main_layout' => __DIR__.'/../../src/Blog/views/layout.html.php',
    'error_500'   => __DIR__.'/../../src/Blog/views/500.html.php',
    'error_404'   => __DIR__.'/../../src/Blog/views/404.html.php',
    'pdo'         => array(
        'dns'      => 'mysql:dbname=mindk_Framework;host=host=127.0.0.1:3307',
        'user'     => 'root',
        'password' => 'a1216'
    ),
    'security'    => array(
        'user_class'    => 'Blog\\Model\\User',
        'login_route'   => 'login'
    ),
    'session'     => array(
        'session_class' =>  ''
    ),
    'config'      => array(
        'config_class'  =>  'Framework\\Services\\Config'
    ),
    'db'          => array(
        'db_class'      =>  'Framework\\Services\\DB'
    )
);