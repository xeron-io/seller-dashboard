<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameServer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'gameservers';
    protected $fillable = [
        'id_seller',
        'name',
        'game',
        'ip',
        'port',
        'api_key'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'id_seller');
    }
}
