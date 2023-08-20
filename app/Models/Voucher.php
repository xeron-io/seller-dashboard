<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'voucher';
    protected $fillable = [
        'id_product',
        'id_store',
        'code',
        'type',
        'amount',
        'limit',
        'expired_at',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id');
    }
}
