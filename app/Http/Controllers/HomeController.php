<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Constants\Constants;
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

        return view('client.home.home', compact(
            'category_products',
            'list_product_new',
            'list_product_best_sell',
            'list_menu_shirt',
            'list_menu_accessories',
            'list_menu_trousers'
        ));
    }
}
