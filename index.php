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

$router->addRoute('/updateHelpRequest', function () {
    require __DIR__ . '/Functions/UpdateHelpRequest.php';
});

$router->addRoute('/sentrequest', function () {
    require __DIR__ . '/Pages/sentrequest.php';
});

$router->addRoute('/studentrequest', function () {
    require __DIR__ . '/Pages/studentrequest.php';
});

$router->addRoute('/courses', function () {
    require __DIR__ . '/Pages/courses.php';
});

$router->addRoute('/schedule', function () {
    require __DIR__ . '/Pages/schedule.php';
});

$router->addRoute('/users/login', function () {
    require (__DIR__ . '/Pages/users/login.php');
});

$router->addRoute('/users/logout', function () {
    require (__DIR__ . '/Pages/users/logout.php');
});
$router->addRoute('/users/register', function () {
    require (__DIR__ . '/Pages/users/register.php');
});

$router->addRoute('/users/forgotpassword', function () {
    require (__DIR__ . '/Pages/users/forgotpassword.php');
});

$router->addRoute('/resetpassword', function () {
    require (__DIR__ . '/Pages/resetpassword.php');
});

$router->addRoute('/passwordreset', function () {
    require (__DIR__ . '/Pages/processresetpassword.php');
});

$router->dispatch();
?>