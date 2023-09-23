<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sellers extends Model
{
    use HasFactory;
    protected $table = 'sellers';
    protected $fillable = [
        'id_membership',
        'firstname',
        'lastname',
        'email',
        'phone',
        'balance',
        'password',
        'pin',
        'access_token',
        'verification_token',
        'isVerified',
        'forget_password_token',
        'status'
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'id_membership', 'id');
    }
}
