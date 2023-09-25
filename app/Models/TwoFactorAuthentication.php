<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactorAuthentication extends Model
{
    use HasFactory;
    protected $table = 'two_factor_authentications';
    protected $fillable = [
        'id_seller',
        'google2fa_enable',
        'google2fa_secret',
        'ip_address',
        'user_agent',
    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'id_seller', 'id');
    }
}
