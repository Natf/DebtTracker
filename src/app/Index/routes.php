<?php

use Slim\Http\Request;
use Slim\Http\Response;

if (isset($app)) {
    $app->get('/register', function (Request $request, Response $response) use ($app) {
        return $this->view->render('views::index', [
            'title' => "Join Debt Tracker for free!"
        ], $response);
    })->setName('Index');
}