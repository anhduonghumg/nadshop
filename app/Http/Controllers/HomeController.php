<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Constants\Constants;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\CategoryProduct\CategoryProductRepositoryInterface;

class HomeController extends Controller
{
    protected $cat;
    protected $product;
    public function __construct(
        CategoryProductRepositoryInterface $cat,
        ProductRepositoryInterface $product
    ) {
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
        $take = 8;
        $category_products = CategoryProduct::where('deleted_at', Constants::EMPTY)->get();
        $list_product_new = $this->product->get_list_product('is_product_new', $take);
        $list_product_best_sell = $this->product->get_list_product('is_product_bestseller', $take);
        $list_menu_shirt = $this->cat->get_cat_menu(Constants::SHIRT_MEN);
        $list_menu_trousers = $this->cat->get_cat_menu(Constants::TROUSERS_MEN);
        $list_menu_accessories = $this->cat->get_cat_menu(Constants::ACCESSORIES_MEN);
        $list_shirt = Product::select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price', 'product_details.product_discount')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->where(function ($query) {
                $query->where('is_product_new', 1)
                    ->orWhere('is_product_bestseller', 1);
            })->where('product_status', Constants::PUBLIC)
            ->where('products.deleted_at', '=', Constants::EMPTY)
            ->where('product_name', 'like', '%Áo%')
            ->orderByDesc('views')
            ->distinct()
            ->take($take)
            ->get();
        $list_trousers = Product::select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price', 'product_details.product_discount')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->where(function ($query) {
                $query->where('is_product_new', 1)
                    ->orWhere('is_product_bestseller', 1);
            })->where('product_status', Constants::PUBLIC)
            ->where('products.deleted_at', '=', Constants::EMPTY)
            ->where('product_name', 'like', '%Quần%')
            ->orderByDesc('views')
            ->distinct()
            ->take($take)
            ->get();
        $list_accessories = Product::select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price', 'product_details.product_discount')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->where(function ($query) {
                $query->where('is_product_new', 1)
                    ->orWhere('is_product_bestseller', 1);
            })->where(function ($query) {
                $query->where('product_cat_id', 27)
                    ->orWhere('product_cat_id', 28)
                    ->orWhere('product_cat_id', 29)
                    ->orWhere('product_cat_id', 30);
            })->where('product_status', Constants::PUBLIC)
            ->where('products.deleted_at', '=', Constants::EMPTY)
            ->orderByDesc('views')
            ->distinct()
            ->take($take)
            ->get();
        return view('client.home.home', compact(
            'category_products',
            'list_product_new',
            'list_product_best_sell',
            'list_menu_shirt',
            'list_menu_accessories',
            'list_menu_trousers',
            'list_shirt',
            'list_trousers',
            'list_accessories'
        ));
    }
}
