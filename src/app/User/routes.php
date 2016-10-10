<?php

use Slim\Http\Request;
use Slim\Http\Response;

if (isset($app)) {
    $app->post('/user/register', function (Request $request, Response $response) use ($app) {
        var_dump($request->getParams()); die;
        return $this->view->render('views::create-user', [
            'title' => "Your Debts",
            'debts' => $allDebts,
        ], $response);
    })->setName('ViewDebts');
}