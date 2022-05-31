<?php

namespace App\Services;

use App\Enums\CurrencyType;
use App\Models\Transaction;
use App\Models\User;

class UserService
{
    public function getUserWalletByCurrencyType(User $user, $currency_type)
    {
        $wallets = $this->getUserWallets($user);

        return $wallets[$currency_type->name ?? $currency_type];
    }

    public function getUserWallets(User $user)
    {
        $user->load('bitcoinWallet', 'ethereumWallet');

        $wallets = [];
        $wallets[CurrencyType::Bitcoin->value] = $user->bitcoinWallet;
        $wallets[CurrencyType::Ethereum->value] = $user->ethereumWallet;

        return $wallets;
    }

    public function userHasSufficientBalance(
        Transaction $transaction,
        User $user = null
    ) {
        $used_wallet = $this->getUserWalletByCurrencyType(
            $user ?? $transaction->sourceUser,
            $transaction->currency_type
        );

        return $used_wallet->balance > $transaction->amount;
    }

    public function subtractAmountFromUserWallet(
        Transaction $transaction,
        User $user = null
    ) {
        $used_wallet = $this->getUserWalletByCurrencyType(
            $user ?? $transaction->sourceUser,
            $transaction->currency_type
        );

        $used_wallet->balance -= $transaction->amount;
        $used_wallet->save();
    }

    public function addAmountToUserWallet(
        Transaction $transaction,
        User $user = null
    ) {
        $used_wallet = $this->getUserWalletByCurrencyType(
            $user ?? $transaction->targetUser,
            $transaction->currency_type
        );

        $used_wallet->balance += $transaction->amount;
        $used_wallet->save();
    }
}
