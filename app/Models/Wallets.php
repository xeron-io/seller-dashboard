<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallets extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'wallets';
    protected $fillable = [
        'id_seller',
        'name',
        'code',
        'number',
        'owner',
    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'id_seller', 'id');
    }
}
