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

    public function register($post)
    {
        $passwordHash = password_hash($post['password'], PASSWORD_DEFAULT);

        $this->user['name'] = $post['name'];
        $this->user['email'] = $post['email'];

        $this->user['id'] = $this->userTunnel->addUser(array_merge($this->user, ['password' => $passwordHash]));

        return $this->user;
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

    public function confirmContact($contactId)
    {
        $this->userTunnel->setContactConfirm($contactId, $this->user['id'], 1);
    }

    public function addContact($contactEmail)
    {
        $contactId = $this->userTunnel->getUserByEmail($contactEmail)['id'];
        $contact = $this->userTunnel->fetchContact($this->user['id'], $contactId);

        if(!empty($contact['contactsRequests'])) {
            $this->userTunnel->setContactConfirm($contactId, $this->user['id'], 1);
        } elseif (empty($contact['contactsRequested'])) {

            $this->userTunnel->addContact($this->user['id'], $contactId);
        }
    }
}