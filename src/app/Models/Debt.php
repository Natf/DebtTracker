<?php

namespace Nat\DebtTracker\Models;

class Debt
{
    public $uid;
    public $name;
    public $email;
    public $dateCreated;
    public $description;
    public $amount;
    public $amountVal;
    public $activeDebts = [];

    public function __construct($uid, $name, $email, $dateCreated, $description, $amountVal)
    {
        $this->name = $name;
        $this->email = $email;
        $this->dateCreated = $dateCreated;
        $this->description = $description;
        $this->amountVal = $amountVal;
        $this->amount = $this->getStringFromValue();
    }

    public function getStringFromValue()
    {
        $amount = round($this->amountVal, 2);

        return "£$amount";
    }
}