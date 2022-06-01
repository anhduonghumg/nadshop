<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Constants\Constants;

class HomeController extends Controller
{
    protected $cat;
    protected $product;
    public function __construct(CategoryProduct $cat, Product $product)
    {
        // $this->middleware('auth');
        $this->cat = $cat;
        $this->product = $product;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        $list_product_new = $this->product
            ->select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->where('products.is_product_new', Constants::TRUE)
            ->orderByDesc('products.id')
            ->distinct()
            ->take(8)
            ->get();

        $list_product_best_sell = $this->product
            ->select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->where('products.is_product_bestseller', Constants::TRUE)
            ->orderByDesc('products.id')
            ->distinct()
            ->take(8)
            ->get();

        $list_menu_shirt = $this->cat
            ->select('category_product_name', 'id')
            ->where('deleted_at', Constants::EMPTY)
            ->where('parent_id', Constants::SHIRT_MEN)
            ->get();

        $list_menu_trousers = $this->cat
            ->select('category_product_name', 'id')
            ->where('deleted_at', Constants::EMPTY)
            ->where('parent_id', Constants::TROUSERS_MEN)
            ->get();

        return view('client.home.home', compact('category_products', 'list_product_new', 'list_product_best_sell', 'list_menu_shirt', 'list_menu_trousers'));
    }
}
