<?php

namespace App\Models;

use App\Enums\CurrencyType;
use App\Enums\TransactionStateType;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

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

    public function users()
    {
        return $this->belongsToMany(User::class, 'transaction_user');
    }

    public function setStateInProgress()
    {
        $this->state = TransactionStateType::IN_PROGRESS;
        $this->save();
    }

    public function setStateComplete()
    {
        $this->state = TransactionStateType::COMPLETED;
        $this->save();
    }

    public function setStateAborted()
    {
        $this->state = TransactionStateType::ABORTED;
        $this->save();
    }
}
