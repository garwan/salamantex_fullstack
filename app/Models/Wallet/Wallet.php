<?php

namespace App\Models\Wallet;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['address', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
