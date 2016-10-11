<?php
session_start();
include(__DIR__ . '/vendor/autoload.php');

require_once __DIR__ . '/src/app/Config/config.php';

$app = new Slim\App($container);

// routes
require_once APP_ROOT . '/app/ViewDebts/routes.php';
require_once APP_ROOT . '/app/Users/routes.php';
require_once APP_ROOT . '/app/Index/routes.php';

$app->add(function (\Slim\Http\Request $request, \Slim\Http\Response $response, $next) use ($app) {
    $page = $request->getUri()->getPath();
    if (($page !== '/' && $page !== '/register' && $page !== '/user/login') && !array_key_exists('user', $_SESSION)) {
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index'));
    }
    return $next($request, $response);
});

$app->get('/', function (\Slim\Http\Request $request, \Slim\Http\Response $response) use ($app) {
    if (array_key_exists('user',$_SESSION)) {
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewDebts'));
    } else {
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index'));
    }
});

$app->run();