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

    public function get_product_order($id)
    {
        $result = $this->select('product_detail_name', 'product_details_thumb', 'product_price', 'pro_order_qty')
            ->join('product_details', 'product_details.id', '=', 'product_order_details.product_detail_id')
            ->where('product_order_details.product_order_id', $id)
            ->get();
        return $result;
    }
}
