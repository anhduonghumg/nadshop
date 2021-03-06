<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product_variant()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'product_cat_id');
    }
}
