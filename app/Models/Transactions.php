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
        'id_voucher',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'ingame_id',
        'reference',
        'merchant_ref',
        'checkout_url',
        'quantity',
        'amount',
        'amount_bersih',
        'pajak',
        'payment_method',
        'status',
        'review_code',
        'cleared_at',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher', 'id')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id')->withTrashed();
    }
    
    public function IsClaimed($id_transaction)
    {
        if(ClaimLog::where('id_transaction', $id_transaction)->first()) {
            return true;
        } else {
            return false;
        }
    }
}
