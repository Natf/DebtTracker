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
            ->where('(user_id = ? OR contact_id = ?)', $user['id'], $user['id'])
            ->fetchAll();
    }

    public function fetchContact($userId, $contactId)
    {
         $yourRequested = $this->fluentPdo
             ->from('Contacts')
             ->select(null)
             ->select('user_id, confirmed')
             ->where('user_id', $userId)
             ->where('contact_id', $contactId)
             ->fetchAll();

         $yourRequests = $this->fluentPdo
             ->from('Contacts')
             ->select(null)
             ->select('user_id, confirmed')
             ->where('contact_id', $userId)
             ->where('user_id', $contactId)
             ->fetchAll();

         return [
             'contactsRequested' => $yourRequested,
             'contactsRequests' => $yourRequests
         ];
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

    public function addContact($userId, $contactId)
    {
        return $this->fluentPdo
            ->insertInto('Contacts')
            ->values([
                'user_id' => $userId,
                'contact_id' => $contactId,
                'request_sent_date' => date('Y-m-d H:i:s')
            ])
            ->execute();
    }

    public function setContactConfirm($userId, $contactId, $confirmed)
    {
        return $this->fluentPdo
            ->update('Contacts')
            ->set(['confirmed' => $confirmed])
            ->where('user_id', $userId)
            ->where('contact_id', $contactId)
            ->execute();
    }
}