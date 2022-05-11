<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'product_order_details';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'pro_order_qty',
        'pro_order_total',
        'product_detail_id',
        'product_order_id'
    ];
}
