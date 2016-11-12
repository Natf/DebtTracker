<?php

namespace  Nat\DebtTracker\Debts\Controllers;

use Nat\DebtTracker\Debts\Models\Debt as DebtTunnel;

class Debt
{
    private $debtTunnel;
    private $userId;

    public function __construct(DebtTunnel $debtTunnel, $userId)
    {
        $this->debtTunnel = $debtTunnel;
        $this->userId = $userId;
    }

    public function addDebt($post)
    {
        $debt_id = $this->debtTunnel->addDebt($post['debt_amount'], $post['description']);

        foreach ($post['users'] as $user) {
            $user = json_decode($user);
            $this->debtTunnel->addDebtsPaid(
                $debt_id, $user->user_id, $user->amount_paid
            );
        }

        return true;
    }

    public function getDebtsBetweenContact($contactId)
    {
        $total = $this->getDebtsForUserGroupedByContacts()[$contactId];
        $debts = $this->getDebtsForUser();

        $userDebts = array_merge($total, ['debts' => $debts]);
        foreach ($userDebts['debts'] as $debtIndex => $debt) {
            foreach ($debt['payment_info']['transactions'] as $index => $transaction) {
                if ($transaction['id'] == $contactId) {
                    break;
                } else if ($index >= (sizeof($debt['payment_info']['transactions']) - 1)) {
                    unset($userDebts['debts'][$debtIndex]);
                }
            }
        }

        return $userDebts;
    }

    public function getDebtsForUserGroupedByContacts($debts = null)
    {
        if($debts === null) {
            $debts = $this->getDebtsForUser();
        }

        $contactDebts = [];
        foreach ($debts as $debt) {
            foreach ($debt['payment_info']['transactions'] as $transaction) {
                $amount = (isset($contactDebts[$transaction['id']]['amount'])) ? $contactDebts[$transaction['id']]['amount'] : 0;
                $amount += $transaction['amount'] * (($debt['owed'] == 1) ? 1 : -1);
                $contactDebts[$transaction['id']] = [
                    'name' => $transaction['name'],
                    'amount' => $amount
                ];
            }
        }

        return $contactDebts;
    }

    public function getDebtsForUser()
    {
        $debts = $this->debtTunnel->getActiveDebtsForUser($this->userId);
        if($debts !== false) {
            $debts = $this->getOutstandingDebts($debts);
        }
        return $debts;
    }

    private function getOutstandingDebts($debts)
    {
        foreach ($debts as $offset => &$debt) {
            $usersPaid = $this->debtTunnel->getDebtsPaidForDebt($debt['id']);
            $debt['payment_info'] = $this->calculateDebtPayments($debt, $usersPaid);
            if(array_key_exists('paid_from', $debt['payment_info'])) {
                $debt['owed'] = 1;
                $debt['payment_info']['transactions'] = $debt['payment_info']['paid_from'];
                unset($debt['payment_info']['paid_from']);
            } else {
                $debt['owed'] = 0;
                $debt['payment_info']['transactions'] = $debt['payment_info']['paid_to'];
                unset($debt['payment_info']['paid_to']);
            }
        }
        return $debts;
    }

    private function calculateDebtPayments($debt, $usersPaid)
    {
        foreach ($usersPaid as $index => &$userPaid) {
            $userPaid['amount_pending'] = $userPaid['amount_owed'] =
                $userPaid['amount_paid'] - ($debt['amount'] / (float)sizeof($usersPaid));
        }

        foreach ($usersPaid as $index => &$userPaid) {
            if ($userPaid['amount_pending'] > 0) {
                $this->calculatePaidFrom($userPaid, $usersPaid);
            }
        }
        return $this->fetchUsersPaymentInfo($usersPaid);
    }

    private function fetchUsersPaymentInfo($usersPaid)
    {
        foreach ($usersPaid as $userPaid) {
            if($userPaid['user_id'] == $this->userId) {
                return $userPaid;
            }
        }

        return [];
    }

    private function calculatePaidFrom(&$userPaid, &$usersPaid)
    {
        while ($userPaid['amount_pending'] > 1) {
            foreach ($usersPaid as &$userOwing) {
                if (($userOwing['amount_pending'] < 0) && ($userPaid['amount_pending'] > 0.01)) {
                    if ($userPaid['amount_pending'] < ($userOwing['amount_pending'] * -1)) {
                        $this->addPayment($userPaid, $userOwing, $userPaid['amount_pending']);
                    } else {
                        $this->addPayment($userPaid, $userOwing, $userOwing['amount_pending'] * -1);
                    }
                }
            }
        }
    }

    public function addPayment(&$userPaid, &$userOwing, $amount)
    {
        $amount = round($amount, 2);
        if (!array_key_exists('paid_from', $userPaid)) {
            $userPaid['paid_from'] = [];
        }

        if (!array_key_exists('paid_to', $userOwing)) {
            $userOwing['paid_to'] = [];
        }

        array_push($userPaid['paid_from'], [
            'id' => $userOwing['user_id'],
            'name' => $userOwing['name'],
            'amount' => $amount
        ]);

        array_push($userOwing['paid_to'], [
            'id' => $userPaid['user_id'],
            'name' => $userPaid['name'],
            'amount' => $amount
        ]);

        $userPaid['amount_pending'] -= $amount;
        $userOwing['amount_pending'] += $amount;
    }
}