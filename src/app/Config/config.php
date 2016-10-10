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
    $dsn = sprintf(
    'mysql:host=%s;port=%d;dbname=%s;charset=utf8',
    '127.0.0.1',
    '3306',
    'debttracker'
    );
    return new \PDO($dsn, 'dbuser', '123');
};

$container['fluentPdo'] = function ($container) {
    return new FluentPDO($container['pdo']);
};