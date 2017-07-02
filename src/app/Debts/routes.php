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
        $user = new \Nat\DebtTracker\Users\Controllers\User($this->fluentPdo, $_SESSION['user']);
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
            'debtsYouOwe' => $youOwe,
            'user' => $user,
            'contacts' => $user->getLiveContactsForUser()
        ], $response);
    })->setName('ViewDebts');

    $app->get('/debts/add', function (Request $request, Response $response) use ($app) {
        $user = new \Nat\DebtTracker\Users\Controllers\User($this->fluentPdo, $_SESSION['user']);
        return $this->view->render('views::add-debt', [
            'title' => 'Add A Debt',
            'user' => $_SESSION['user'],
            'contacts' => $user->getLiveContactsForUser()
        ], $response);
    });

    $app->get('/debts/create', function (Request $request, Response $response) use ($app) {
        $user = new \Nat\DebtTracker\Users\Controllers\User($this->fluentPdo, $_SESSION['user']);
        return $this->view->render('views::add-debt--new', [
            'title' => 'Add A Debt',
            'user' => $_SESSION['user'],
            'contacts' => $user->getLiveContactsForUser()
        ], $response);
    });

    $app->post('/debts/create', function(Request $request, Response $response) use ($app) {
        $post = $request->getParams();
        $debt = new Debt(new DebtTunnel($this->fluentPdo), $_SESSION['user']['id']);
        if($debt->addDebt($post)) {
            return 'successful';
        } else {
            return 'unsuccessful';
        }
    });

    $app->get('/debts/paycontact', function(Request $request, Response $response) use ($app) {
        $user = new \Nat\DebtTracker\Users\Controllers\User($this->fluentPdo, $_SESSION['user']);
        $params = $request->getParams();
        $debt = new Debt(new DebtTunnel($this->fluentPdo), $_SESSION['user']['id']);

        if(array_key_exists('contact_id', $params) && !empty($params['contact_id'])) {
            return $this->view->render('views::pay-debt', [
                'title' => 'Add A Debt',
                'user' => $_SESSION['user'],
                'contactDebt' => $debt->getDebtsBetweenContact($params['contact_id']),
            ], $response);
        } else {
            return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewDebts'));
        }
    });
}