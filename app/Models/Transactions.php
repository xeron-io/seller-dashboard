<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'transactions';
    protected $fillable = [
        'id_store',
        'id_product',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'ingame_id',
        'reference',
        'merchant_ref',
        'checkout_url',
        'quantity',
        'amount',
        'payment_method',
        'status',
        'review_code',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
}
