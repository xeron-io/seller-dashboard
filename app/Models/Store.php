<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $fillable = [
        'id_seller',
        'id_theme',
        'name',
        'description',
        'domain',
        'youtube',
        'instagram',
        'tiktok',
        'facebook',
        'phone',
        'discord',
        'status',
        'logo',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'id_seller', 'id');
    }

    public function theme()
    {
        return $this->belongsTo(Themes::class, 'id_theme', 'id');
    }
}
