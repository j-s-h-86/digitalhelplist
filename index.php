<?php
// globala initieringar !
require_once (dirname(__FILE__) . "/Utils/Router.php");
require_once ("vendor/autoload.php");

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ . '/Pages/index.php';
});

$router->addRoute('/public', function () {
    require __DIR__ . '/Pages/public.php';
});

$router->addRoute('/student', function () {
    require (__DIR__ . '/Pages/student.php');
});


$router->addRoute('/admin', function () {
    require __DIR__ . '/Pages/admin.php';
});

$router->addRoute('/helpform', function () {
    require __DIR__ . '/Pages/helpform.php';
});
$router->addRoute('/helplist', function () {
    require __DIR__ . '/Pages/helplist.php';
});

$router->addRoute('/user/login', function () {
    require (__DIR__ . '/Pages/users/login.php');
});

$router->addRoute('/user/logout', function () {
    require (__DIR__ . '/Pages/users/logout.php');
});

$router->dispatch();
?>