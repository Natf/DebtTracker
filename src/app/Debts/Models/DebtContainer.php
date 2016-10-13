<?php

namespace  Nat\DebtTracker\Models;

use Nat\DebtTracker\Models\Debt;

class DebtContainer
{
    public $message;
    public $email;
    public $uid;
    public $amount = '';
    public $amountVal = 0;
    public $owed = [];
    public $owedTooYou = [];

    public function __construct($uid)
    {
        $this->uid = $uid;
        $this->email = $this->getEmailByUid($uid);
    }

    public function addOwed($owed)
    {
        array_push($this->owed, $owed);
        $this->updateTotals();
    }

    public function addOwedToYou($owedTooYou)
    {
        array_push($this->owedTooYou, $owedTooYou);
        $this->updateTotals();
    }

    public function updateTotals()
    {
        $this->amountVal = $this->getDebtSum();
        $this->amount = $this->getStringFromValue();
        $this->message = $this->getMessage();
    }

    public function getStringFromValue()
    {
        $amount = round($this->amountVal, 2);

        return ($amount > 0) ? "£$amount" : "£".($amount*-1);
    }

    public function getMessage()
    {
        if ($this->amountVal !== 0) {
            return sprintf("You %s a total of: %s",
                ($this->amountVal > 0)? "owe" : "are owed",
                $this->amount
            );
        }
        return "No outstanding debts";
    }

    public function getEmailByUid($uid)
    {
        return '';
    }

    public function getDebtSum()
    {
        return $this->sumDebts($this->owedTooYou) - $this->sumDebts($this->owed);
    }

    public function sumDebts($debts)
    {
        $total = 0;

        foreach ($debts as $debt) {
            $total += $debt->amountVal;
        }

        return $total;
    }
}