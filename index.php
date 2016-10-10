<?php
include(__DIR__ . '/vendor/autoload.php');
session_start();

require_once __DIR__ . '/src/app/Config/config.php';

$app = new Slim\App($container);
// routes
require_once APP_ROOT . '/app/ViewDebts/routes.php';
require_once APP_ROOT . '/app/Users/routes.php';
require_once APP_ROOT . '/app/Index/routes.php';

$app->get('/', function (\Slim\Http\Request $request, \Slim\Http\Response $response) use ($app) {
    if (array_key_exists('uid',$_SESSION)) {
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewDebts'));
    } else {
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index'));
    }
});

$app->run();