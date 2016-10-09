<?php
include(__DIR__ . '/vendor/autoload.php');
session_start();

require_once __DIR__ . '/src/app/Config/config.php';

$app = new Slim\App($container);
// routes
require_once APP_ROOT . '/app/ViewDebts/routes.php';

$app->get('/', function (\Slim\Http\Request $request, \Slim\Http\Response $response) use ($app) {
    return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewDebts'));
})->setName('Index');

$app->run();