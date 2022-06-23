<?php

use App\Router;

require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();



if(isset($_GET['page']) && $_GET['page'] === '1'){
    $uri = $_SERVER['REQUEST_URI'];
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($_GET['page']);
    $query = http_build_query($get);
    if (!empty($query)){
        $uri = $uri . '?' . $query;
    }
    header('Location: ' . $uri);
    http_response_code(301);
    exit();
}

$router = new AltoRouter();

$router = new Router(dirname(__DIR__) .  '/views');
$router
    ->get('/', '/post/index', 'home')
    ->get('/blog/category/[*:slug]-[i:id]', '/category/show', 'category')
    ->get('/blog/[*:slug]-[i:id]', '/post/show', 'post')
    ->run();
