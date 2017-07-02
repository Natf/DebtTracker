<?php
session_start();
include(__DIR__ . '/vendor/autoload.php');

require_once __DIR__ . '/src/app/Config/config.php';

$app = new Slim\App($container);

// routes
require_once APP_ROOT . '/app/Debts/routes.php';
require_once APP_ROOT . '/app/Users/routes.php';
require_once APP_ROOT . '/app/Index/routes.php';

$app->add(function (\Slim\Http\Request $request, \Slim\Http\Response $response, $next) use ($app) {
    $page = $request->getUri()->getPath();
    if (($page !== '/' && $page !== '/forgottenyourpassword' & $page !== '/register' && $page !== '/user/register' && $page !== '/user/login') && !array_key_exists('user', $_SESSION)) {
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index'));
    }
    return $next($request, $response);
});

$app->get('/', function (\Slim\Http\Request $request, \Slim\Http\Response $response) use ($app) {
    $response = $response->withoutHeader('Content-Length');
    if (array_key_exists('user',$_SESSION)) {
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewDebts'));
    } else {
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index'));
    }
});

/**
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 */
function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next) {
    /**
     * @var $response \Psr\Http\Message\ServerRequestInterface
     */
    $response = $next($request, $response);
    return $response->withoutHeader('Content-Length');

//    return $response;
};

$app->run();