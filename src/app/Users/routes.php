<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Nat\DebtTracker\Users\Validators\Register;

if (isset($app)) {
    $app->post('/user/register', function (Request $request, Response $response) use ($app) {
        $post = $request->getParams();
        $register = new Register($post);
        if ($register->validate()) {
            $user = new \Nat\DebtTracker\Users\Models\User($this->fluentPdo);
            $user->register($post);
            $user = [
                'email' => $user->email,
                'name' => $user->name,
                'id' => $user->id
            ];
            $_SESSION['user'] = $user;
            return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewDebts'));
        } else {
            return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index') . '?registererror=1');
        }
    })->setName('Register');

    $app->post('/user/login', function (Request $request, Response $response) use ($app) {
        $post = $request->getParams();
        $user = new \Nat\DebtTracker\Users\Models\User($this->fluentPdo);
        if($user->login($post)) {
            // todo this needs to be abstracted to a class
            $user = [
                'email' => $user->email,
                'name' => $user->name,
                'id' => $user->id
            ];
            $_SESSION['user'] = $user;
            return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewDebts'));
        } else {
            return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index') . '?loginerror=1');
        }
    })->setName('Login');

    $app->get('/user/logout', function(Request $request, Response $response) use ($app) {
        session_destroy();
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index'));
    });

    $app->get('/user/contacts', function(Request $request, Response $response) use ($app) {
        $user = new \Nat\DebtTracker\Users\Models\User($this->fluentPdo, $_SESSION['user']);
        return $this->view->render('views::contacts', [
            'title' => "Your Contacts",
            'contacts' => $user->fetchContacts(),
            'requestedContacts' => $user->fetchSentContactRequests(),
            'pendingContacts' => $user->fetchContactRequests()
        ], $response);
    })->setName('ViewContacts');

    $app->post('/user/addcontact', function(Request $request, Response $response) use ($app) {
        $post = $request->getParams();
        $user = new \Nat\DebtTracker\Users\Models\User($this->fluentPdo, $_SESSION['user']);
        $user->addContact($post);
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewContacts'));
    });
}