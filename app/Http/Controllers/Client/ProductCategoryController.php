<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Constants\Constants;
use App\Models\Color;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\CategoryProduct\CategoryProductRepositoryInterface;
use App\Models\Product;
use App\Models\Size;

class ProductCategoryController extends Controller
{
    protected $product;
    protected $catProduct;

    public function __construct(
        ProductRepositoryInterface $product,
        CategoryProductRepositoryInterface $catProduct
    ) {
        $this->product = $product;
        $this->catProduct = $catProduct;
    }

    public function show($id)
    {
        $id = isset($id) ? (int)$id : null;
        $category_products = CategoryProduct::where('deleted_at', Constants::EMPTY)->get();
        $list_products = $this->product->get_product_by_cat($id);
        $get_name_category = $this->catProduct->find($id);
        $list_color = Color::all();
        $list_size = Size::all();
        return view('client.categoryProduct.show', compact('category_products', 'list_products', 'get_name_category', 'id', 'list_color','list_size'));
    }
}
