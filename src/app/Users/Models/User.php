<?php

namespace Nat\DebtTracker\Users\Models;

class User
{
    private $fluentPDO;
    public $name;
    public $email;

    public function __construct(\FluentPDO $fluentPDO)
    {
        $this->fluentPDO = $fluentPDO;
    }

    public function register($args)
    {
        $passwordHash = password_hash($args['password'], PASSWORD_DEFAULT);

        $this->fluentPDO->insertInto('Users')->values([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => $passwordHash
        ])->execute();
    }

    public function login($args)
    {
        $email = $args['email'];

        $user = $this->fluentPDO
            ->from('Users')
            ->select(null)
            ->select('password, name')
            ->where('email', $email)
            ->fetchAll()[0];

        if(password_verify($args['password'], $user['password'])) {
            $this->name = $user['name'];
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }
}