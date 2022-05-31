<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Constants\Constants;

class ProductController extends Controller
{
    protected $product;
    public function __construct(Product $product, CategoryProduct $cat)
    {
        $this->product = $product;
        $this->cat = $cat;
    }

    public function detail($id)
    {
        $pro_id = (int)$id;

        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        $product = $this->product
            ->join('product_details', 'product_details.product_id', '=', 'products.id')
            ->where('products.id', $pro_id)
            ->get();

        return view('client.product.detail', compact('product', 'category_products'));
    }
}
