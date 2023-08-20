<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'stores';
    protected $fillable = [
        'id_seller',
        'id_gameserver',
        'id_theme',
        'name',
        'description',
        'domain',
        'custom_domain',
        'youtube',
        'instagram',
        'tiktok',
        'facebook',
        'phone',
        'discord',
        'status',
        'logo',
        'api_key',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'id_seller', 'id');
    }
    
    public function gameserver()
    {
        return $this->belongsTo(Gameserver::class, 'id_gameserver', 'id');
    }

    public function theme()
    {
        return $this->belongsTo(Themes::class, 'id_theme', 'id');
    }
}
