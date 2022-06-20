<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Constants\Constants;
use App\Models\CategoryProduct;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\District;
use App\Models\City;

class CartController extends Controller
{
    protected $product;
    protected $productRepo;
    protected $city;
    protected $district;
    public function __construct(
        Product $product,
        CategoryProduct $cat,
        ProductRepositoryInterface $productRepo,
        City $city,
        District $district
    ) {
        $this->product = $product;
        $this->productRepo = $productRepo;
        $this->cat = $cat;
        $this->city = $city;
        $this->district = $district;
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

    public function buy(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $product = Product::join('product_details', 'product_details.product_id', '=', 'products.id')
                ->where('products.id', $id)
                ->first();
            $list_colors = $this->productRepo->get_color_by_product($id);
            $result = [
                'product' => $product,
                'list_colors' => $list_colors,
            ];
            return response()->json($result);
        }
    }

    public function checkout()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        $list_city = $this->city->all();
        return view('client.cart.checkout', compact('category_products', 'list_city'));
    }

    public function order()
    {
    }
}
