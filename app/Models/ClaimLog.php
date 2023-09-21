<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClaimLog extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    protected $table = 'claim_log';
    protected $fillable = [
        'id_transaction',
        'ip_address',
        'claimed_at',
    ];
}
