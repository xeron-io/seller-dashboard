<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Themes extends Model
{
   use HasFactory;
   protected $table = 'themes';
   protected $fillable = [
      'id_membership',
      'name',
      'description',
      'thumbnail',
      'preview',
   ];
}
