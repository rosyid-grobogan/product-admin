<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title_product', 'brands', 'category', 'subcategory', 'keterangan'
    ];
    protected $table = 'tabelBE';
}
