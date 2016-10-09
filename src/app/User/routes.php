<?php

use Slim\Http\Request;
use Slim\Http\Response;

if (isset($app)) {
    $app->get('/user/create', function (Request $request, Response $response) use ($app) {
        $debtFetcher = new Nat\DebtTracker\Controllers\Debts();
        $allDebts = $debtFetcher->fetchAllDebtsByUid();
        return $this->view->render('views::create-user', [
            'title' => "Your Debts",
            'debts' => $allDebts,
        ], $response);
    })->setName('ViewDebts');
}