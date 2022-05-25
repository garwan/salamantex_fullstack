<?php

namespace App\Enums;

enum TransactionStateType: string
{
    case IN_QUEUE = 'IN_QUEUE';
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMPLETED';
    case ABORTED = 'ABORTED';
}
