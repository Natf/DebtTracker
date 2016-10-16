<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Nat\DebtTracker\Debts\Controllers\Debt;
use Nat\DebtTracker\Debts\Models\Debt as DebtTunnel;

if (isset($app)) {
    $app->get('/debts/view', function (Request $request, Response $response) use ($app) {
        $debtFetcher = new Debt(new DebtTunnel($this->fluentPdo), $_SESSION['user']['id']);
        $allDebts = $debtFetcher->getDebtsForUser();
        $contactDebts = $debtFetcher->getDebtsForUserGroupedByContacts($allDebts);
        $owedToYou = $youOwe = [];
        foreach ($allDebts as $debt) {
            if($debt['owed'] == 1) {
                array_push($owedToYou, $debt);
            } else {
                array_push($youOwe, $debt);
            }
        }
        return $this->view->render('views::view-debts', [
            'title' => 'Your Debts',
            'contactDebts' => $contactDebts,
            'debtsOwedToYou' => $owedToYou,
            'debtsYouOwe' => $youOwe
        ], $response);
    })->setName('ViewDebts');

    $app->get('/debts/add', function (Request $request, Response $response) use ($app) {
        $user = new \Nat\DebtTracker\Users\Controllers\User($this->fluentPdo, $_SESSION['user']);
        return $this->view->render('views::add-debt', [
            'title' => 'Add A Debt',
            'contacts' => $user->getLiveContactsForUser()
        ], $response);
    });
}