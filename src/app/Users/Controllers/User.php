<?php

namespace Nat\DebtTracker\Users\Controllers;

use Nat\DebtTracker\Users\Models\User as UserTunnel;

class User
{
    private $userTunnel;
    private $user;

    public function __construct(\FluentPDO $fluentPdo, $user = null)
    {
        $this->userTunnel = new UserTunnel($fluentPdo);
        $this->user = $user;
    }

    public function register($args)
    {
        $passwordHash = password_hash($args['password'], PASSWORD_DEFAULT);

        $this->name = $args['name'];
        $this->email = $args['email'];

        $id = $this->id = $this->fluentPDO->insertInto('Users')->values([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => $passwordHash
        ])->execute();

        return [
            'id' => $id,
            'name' => $args['name'],
            'email' => $args['email']
        ];
    }

    public function login($args)
    {
        $email = $args['email'];

        $user = $this->userTunnel->getUserByEmail($email);

        if(password_verify($args['password'], $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function getAllContactsForUser()
    {
        $liveContacts = $this->userTunnel->fetchContacts($this->user);
        $pendingContactRequests = $this->userTunnel->fetchSentContactRequests($this->user);
        $contactRequests = $this->userTunnel->fetchContactRequests($this->user);

        return [
            'liveContacts' => $liveContacts,
            'pendingContactRequests' => $pendingContactRequests,
            'contactRequests' => $contactRequests
        ];
    }
}