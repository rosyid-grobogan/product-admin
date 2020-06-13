<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'name', 'parent'
    ];
    protected $table = 'subcategory';
}
