<?php

namespace Nat\DebtTracker\Users\Models;

class User
{
    private $fluentPDO;
    private $name;
    private $email;

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
}