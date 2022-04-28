<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    function user()
    {
        return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    }

    function size()
    {
        return $this->belongsTo(Size::class);
    }

    function color()
    {
        return $this->belongsTo(Color::class);
    }

    function product()
    {
        return $this->belongsTo('App\models\Product', 'product_id', 'id');
    }
}
