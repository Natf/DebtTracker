<?php

use Slim\Http\Request;
use Slim\Http\Response;

if (isset($app)) {
    $app->get('/debts/view', function (Request $request, Response $response) use ($app) {
        $debtFetcher = new Nat\DebtTracker\Controllers\Debts();
        $allDebts = $debtFetcher->fetchAllDebtsByUid();
        return $this->view->render('views::view-debts', [
            'title' => "Your Debts",
            'debts' => $allDebts,
        ], $response);
    })->setName('ViewDebts');
}