<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'withdraw';
    protected $fillable = [
        'id_seller',
        'wallet_number',
        'wallet_code',
        'wallet_name',
        'wallet_owner',
        'amount',
        'proof',
        'fee',
        'balance_before',
        'balance_after',
        'status',
    ];
    
    public function wallet()
    {
        return $this->belongsTo(Wallets::class, 'id_wallet', 'id')->withTrashed();
    }
}
