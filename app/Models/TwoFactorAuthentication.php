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
    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'id_seller', 'id');
    }
}
