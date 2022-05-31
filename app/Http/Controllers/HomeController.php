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
        $list_product_new = $this->product->all();
        return view('client.home.home', compact('category_products', 'list_product_new'));
    }
}
