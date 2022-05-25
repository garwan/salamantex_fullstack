<?php

namespace App\Models;

use App\Enums\CurrencyType;
use App\Enums\TransactionStateType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_id',
        'target_id',
        'currency_type',
        'amount',
        'state',
        'processed_at',
    ];

    protected $casts = [
        'state' => TransactionStateType::class,
        'currency_type' => CurrencyType::class,
    ];

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_id');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_id');
    }
}
