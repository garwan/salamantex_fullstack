<?php

namespace App\Services;

use App\Enums\CurrencyWalletModelType;

class WalletService
{
    public function getWalletModelByType($wallet_type)
    {
        $wallets = [];

        foreach (CurrencyWalletModelType::cases() as  $value) {
            $wallets[$value->name] = $value->value;
        }

        return app($wallets[$wallet_type]);
    }
}
