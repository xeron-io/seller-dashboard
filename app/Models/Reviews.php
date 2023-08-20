<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reviews extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'review';
    protected $fillable = [
        'id_transaction',
        'buyer_name',
        'buyer_email',
        'star',
        'comment',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'id_transaction', 'id');
    }
}
