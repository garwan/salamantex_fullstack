<?php

namespace App\Enums;

enum TransactionError: string
{
    case WALLET_NOT_FOUND = "Transaction could not be executed because either sender or reciever does not have wallet of selected currency.";
    case INSUFFICIENT_BALANCE = "Transaction could not be executed because sender does not have sufficient amount of selected currency.";
    case EXECUTE_ERROR = "Transaction can not be executed.";
}
