<?php
// globala initieringar !
require_once(dirname(__FILE__) ."/Utils/Router.php");

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ .'/Pages/index.php';
});

$router->addRoute('/public', function () {
    require __DIR__ .'/Pages/public.php';
});

$router->addRoute('/student', function () {
    require(__DIR__ .'/Pages/student.php');
});


$router->addRoute('/admin', function () {
    require __DIR__ .'/Pages/admin.php';
});

$router->addRoute('/input', function () {
    require __DIR__ .'/Pages/form.php';
});

$router->addRoute('/viewcustomer', function () {
    require __DIR__ .'/Pages/viewcustomer.php';
});

$router->addRoute('/user/login', function () {
    require(__DIR__ .'/Pages/users/login.php');
});

$router->addRoute('/user/logout', function () {
    require(__DIR__ .'/Pages/users/logout.php');
});

$router->dispatch();
?>