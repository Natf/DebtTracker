<?php

namespace Nat\DebtTracker\Debts\Models;

class Debt
{
    private $fluentPdo;

    public function __construct(\FluentPDO $fluentPdo)
    {
        $this->fluentPdo = $fluentPdo;
    }

    public function getActiveDebtsForUser($userId)
    {
        return $this->fluentPdo
            ->from('Debts_Paid')
            ->select(null)
            ->select('*')
            ->leftJoin('Debts ON Debts.id = Debts_Paid.debt_id')
            ->where('Debts.fully_paid = 0')
            ->where('Debts_Paid.user_id', $userId)
            ->fetchAll();
    }

    public function getDebtsPaidForDebt($debtId)
    {
        return $this->fluentPdo
            ->from('Debts_Paid')
            ->select(null)
            ->select('debt_id, user_id, amount_paid, id, name')
            ->leftJoin('Users ON Debts_Paid.user_id = Users.id')
            ->where('debt_id', $debtId)
            ->orderBy('amount_paid DESC')
            ->fetchAll();
    }

    public function getAmountOfUsersForDebt($debtId)
    {
        return $this->fluentPdo
            ->from('Debts_Paid')
            ->select(null)
            ->select('COUNT(*) AS count')
            ->where('debt_id', $debtId)
            ->fetchAll()[0]['count'];
    }
}