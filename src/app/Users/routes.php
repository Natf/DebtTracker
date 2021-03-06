<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Nat\DebtTracker\Users\Validators\Register;
use Nat\DebtTracker\Users\Controllers\User;

if (isset($app)) {
    $app->post('/user/register', function (Request $request, Response $response) use ($app) {
        $post = $request->getParams();
        $register = new Register($post);
        if ($register->validate()) {
            $user = new User($this->fluentPdo);
            $_SESSION['user'] = $user->register($post);
            return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewDebts'));
        } else {
            return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index') . '?registererror=1');
        }
    })->setName('Register');

    $app->post('/user/login', function (Request $request, Response $response) use ($app) {
        $post = $request->getParams();
        $user = new User($this->fluentPdo);
        if($user = $user->login($post)) {
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

    $app->get('/forgottenyourpassword', function(Request $request, Response $response) use ($app) {
        return $this->view->render('views::forgotten-password-form', [
            'title' => "Forgotten Your Password"
        ], $response);
    });

    $app->post('/forgottenyourpassword', function(Request $request, Response $response) use ($app) {
        $user = new User($this->fluentPdo);
        $user->resetPasswordForUser($request->getParams());
        return $response->withRedirect($app->getContainer()->get('router')->pathFor('Index'));
    });

    $app->get('/user/contacts', function(Request $request, Response $response) use ($app) {
        $user = new User($this->fluentPdo, $_SESSION['user']);
        return $this->view->render('views::contacts', [
            'title' => "Your Contacts",
            'contacts' => $user->getAllContactsForUser()
        ], $response);
    })->setName('ViewContacts');

    $app->post('/user/addcontact', function(Request $request, Response $response) use ($app) {
        $contactEmail = $request->getParam('email');
        $user = new User($this->fluentPdo, $_SESSION['user']);
        $user->addContact($contactEmail);
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewContacts'));
    });

    $app->get('/user/contacts/confirm', function(Request $request, Response $response) use ($app) {
        $contact = $request->getParam('user_id');
        $user = new User($this->fluentPdo, $_SESSION['user']);
        $user->confirmContact($contact);
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('ViewContacts'));
    });
}