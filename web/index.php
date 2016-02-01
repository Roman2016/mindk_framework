<h2>index file</h2>
<?php

require_once(__DIR__.'/../framework/Loader.php');

Loader::addNamespacePath('Blog\\',__DIR__.'/../src/Blog');

$app = new \Framework\Application(__DIR__.'/../app/config/config.php');

$app->run();

$app2 = new \Framework\DI\Service; // проверка автоподгрузчика

Loader::returnNamespacePath();

$app3 = new Blog\Controller\PostController;

