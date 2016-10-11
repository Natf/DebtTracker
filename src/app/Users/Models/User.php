<?php

namespace Nat\DebtTracker\Users\Models;

class User
{
    private $fluentPdo;

    public function __construct(\FluentPDO $fluentPdo)
    {
        $this->fluentPdo = $fluentPdo;
    }

    public function getUserByEmail($email)
    {
        return $this->fluentPdo
            ->from('Users')
            ->select(null)
            ->select('id, password, name, email')
            ->where('email', $email)
            ->fetchAll()[0];
    }

    public function fetchContacts($user)
    {
        return $this->fluentPdo
            ->from('Contacts')
            ->select(null)
            ->select('Users.name, Users.email')
            ->leftJoin('Users ON Users.id = Contacts.contact_id')
            ->where('confirmed = 1')
            ->where('user_id', $user['id'])
            ->fetchAll();
    }

    public function fetchSentContactRequests($user)
    {
        return $this->fluentPdo
            ->from('Contacts')
            ->select(null)
            ->select('Users.name, Users.email')
            ->leftJoin('Users ON Users.id = Contacts.contact_id')
            ->where('confirmed = 0')
            ->where('user_id', $user['id'])
            ->fetchAll();
    }

    public function fetchContactRequests($user)
    {
        return $this->fluentPdo
            ->from('Contacts')
            ->select(null)
            ->select('Users.name, Users.email, Users.id')
            ->leftJoin('Users ON Users.id = Contacts.user_id')
            ->where('confirmed = 0')
            ->where('contact_id', $user['id'])
            ->fetchAll();
    }

    public function addContact($user)
    {
        return $this->fluentPdo
            ->update('Contacts')
            ->set(['confirmed' => 1])
            ->where('user_id', 1)
            ->where('contact_id', $user['id'])
            ->execute();
    }
}