<?php

namespace App\Enums;

use App\Models\Wallet\BitcoinWallet;
use App\Models\Wallet\EthereumWallet;

enum CurrencyWalletModelType: string
{
    case Bitcoin = BitcoinWallet::class;
    case Ethereum = EthereumWallet::class;
}
