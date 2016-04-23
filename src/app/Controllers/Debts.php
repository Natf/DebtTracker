<?php

namespace  Nat\DebtTracker\Controllers;

use Nat\DebtTracker\Models\Debt;
use Nat\DebtTracker\Models\DebtContainer;

class Debts
{
    public function __construct()
    {

    }

    public function fetchAllDebtsByUid()
    {
        $allDebts = new DebtContainer(1);

        for ($i = 10; $i > 0; $i--) {
            $allDebts->addOwed(new Debt(
                1,
                'test name',
                'testemail',
                'a date',
                'a description',
                (float)rand(100, 1000)/100
            ));
        }

        for ($i = 10; $i > 0; $i--) {
            $allDebts->addOwedToYou(new Debt(
                1,
                'test name',
                'test owed 2 u',
                'a date owed 2 u',
                'a description owed 2 u',
                (float)rand(100, 1000)/100
            ));
        }

        return $allDebts;
    }
}