<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $guarded = [];


    // public function get_list_category_product($key, $column, $value, $operator, $options = [])
    // {

    //     $result =  DB::table('category_products')
    //         ->join('M_users', 'M_users.id', '=', 'category_products.user_id')
    //         ->where("category_products.{$column}", "{$operator}", $value)
    //         ->where("category_products.deleted_at", '=', Constants::EMPTY)
    //         ->where("categpry_products.category_product_name", "LIKE", "%{$key}%")
    //         ->orderBy('category_products.created_at', 'desc')
    //         ->paginate(20);

    //     return $result;
    // }
}
