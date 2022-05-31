<?php

namespace App\Services;

use App\Enums\CurrencySymbol;

class CurrencyService
{
    public function getListOfCurrencies()
    {
        $cases = CurrencySymbol::cases();
        $list = [];

        foreach ($cases as $case) {
            $list[$case->name] = $case->value;
        }

        return $list;
    }
}
