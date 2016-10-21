<?php

define('APP_ROOT', realpath(__DIR__) . '/../../');

$container = new \Slim\Container([]);

$container['view'] = function ($container) {
    $viewEngine =  new \Nat\DebtTracker\View\Engine(realpath(APP_ROOT . '/templates/'), 'phtml');
    $viewEngine->addFolder('layouts', realpath(APP_ROOT . '/templates/layouts/'));
    $viewEngine->addFolder('views', realpath(APP_ROOT . '/templates/views/'));
    $viewEngine->addFolder('partials', realpath(APP_ROOT . '/templates/partials/'));

    return $viewEngine;
};

$container['settings']['displayErrorDetails'] = true;

$container['pdo'] = function ($container) {
    $MYSQL_HOST_NAME = '127.0.0.1';
    $MYSQL_PORT = '3306';
    $MYSQL_USERNAME = 'dbuser';
    $MYSQL_PASSWORD = '123';

    $dsn = sprintf(
    'mysql:host=%s;port=%d;dbname=%s;charset=utf8',
        $MYSQL_HOST_NAME,
        $MYSQL_PORT ,
    'debttracker'
    );
    return new \PDO($dsn, $MYSQL_USERNAME, $MYSQL_PASSWORD);
};

$container['fluentPdo'] = function ($container) {
    return new FluentPDO($container['pdo']);
};

if(array_key_exists('user', $_SESSION)) {
    $container['user'] = $_SESSION['user'];
}