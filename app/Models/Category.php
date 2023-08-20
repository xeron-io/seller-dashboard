<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'category';
    protected $fillable = [
        'id_store',
        'name',
        'slug',
        'description',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id');
    }
}
