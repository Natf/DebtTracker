<?php

namespace Nat\DebtTracker\Users\Models;

class User
{
    private $fluentPDO;
    public $id;
    public $name;
    public $email;

    public function __construct(\FluentPDO $fluentPDO, $user = null)
    {
        $this->fluentPDO = $fluentPDO;
        if ($user !== null) {
            $this->id = $user['id'];
            $this->name = $user['name'];
            $this->email = $user['email'];
        }
    }

    public function register($args)
    {
        $passwordHash = password_hash($args['password'], PASSWORD_DEFAULT);

        $this->name = $args['name'];
        $this->email = $args['email'];

        $this->id = $this->fluentPDO->insertInto('Users')->values([
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
            ->select('id, password, name')
            ->where('email', $email)
            ->fetchAll()[0];

        if(password_verify($args['password'], $user['password'])) {
            $this->name = $user['name'];
            $this->email = $email;
            $this->id = $user['id'];
            return true;
        } else {
            return false;
        }
    }

    public function fetchContacts()
    {
        return $this->fluentPDO
            ->from('Contacts')
            ->select(null)
            ->select('Users.name, Users.email')
            ->leftJoin('Users ON Users.id = Contacts.contact_id')
            ->where('confirmed = 1')
            ->where('user_id', $this->id)
            ->fetchAll();
    }

    public function fetchSentContactRequests()
    {
        return $this->fluentPDO
            ->from('Contacts')
            ->select(null)
            ->select('Users.name, Users.email')
            ->leftJoin('Users ON Users.id = Contacts.contact_id')
            ->where('confirmed = 0')
            ->where('user_id', $this->id)
            ->fetchAll();
    }

    public function fetchContactRequests()
    {
        return $this->fluentPDO
            ->from('Contacts')
            ->select(null)
            ->select('Users.name, Users.email')
            ->leftJoin('Users ON Users.id = Contacts.user_id')
            ->where('confirmed = 0')
            ->where('contact_id', $this->id)
            ->fetchAll();
    }

    public function addContact($args)
    {
        $contact = $this->fluentPDO
            ->from('Users')
            ->select(null)
            ->select('id')
            ->where('email', $args['email'])
            ->fetchAll()[0];

        return $this->fluentPDO
            ->insertInto('Contacts')
            ->values([
                'user_id' => $this->id,
                'contact_id' => $contact['id'],
                'request_sent_date' => date("Y-m-d H:i:s"),
            ])
            ->execute();
    }
}