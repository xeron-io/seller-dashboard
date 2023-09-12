<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product';
    protected $fillable = [
        'id_category',
        'id_store',
        'name',
        'slug',
        'price',
        'image',
        'ingame_command',
        'description',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id')->withTrashed();
    }
}
