<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Nat\DebtTracker\Users\Validators\Register;

if (isset($app)) {
    $app->post('/user/register', function (Request $request, Response $response) use ($app) {
        $post = $request->getParams();
        $register = new Register($post);
        if ($register->validate()) {
            echo "registered";
            $user = new \Nat\DebtTracker\Users\Models\User($this->fluentPdo);
            $user->register($post);
//            return $this->view->render('views::create-user', [
//                'title' => "Your Debts",
//                'debts' => $allDebts,
//            ], $response);
        }
    })->setName('Register');

    $app->post('/user/login', function (Request $request, Response $response) use ($app) {
        $post = $request->getParams();
        $user = new \Nat\DebtTracker\Users\Models\User($this->fluentPdo);
        if($user->login($post)) {
            $user = [
                'email' => $user->email,
                'name' => $user->name
            ];
            $_SESSION['user'] = $user;
        } else {
            return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index') . '?loginerror=1');
        }
    })->setName('Login');

    $app->get('/user/logout', function(Request $request, Response $response) use ($app) {
        session_destroy();
        return $response->withRedirect($app->getContainer()->get('router')->pathfor('Index'));
    });
}