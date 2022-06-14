<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Constants\Constants;
use App\Models\CategoryProduct;

class CartController extends Controller
{
    public function __construct(CategoryProduct $cat)
    {
        $this->cat = $cat;
    }

    public function show()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        return view('client.cart.show', compact('category_products'));
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            $variant_id = $request->product_variant;
            $product_info = ProductDetail::where('id', $variant_id)->first(['product_detail_name', 'product_price', 'product_details_thumb']);
            return response()->json($product_info);
        }
    }
}
