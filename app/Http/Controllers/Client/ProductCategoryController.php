<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Constants\Constants;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
    }

    public function show($id)
    {
        $id = isset($id) ? (int)$id : null;
        $category_products = CategoryProduct::where('deleted_at', Constants::EMPTY)->get();

        return view('client.categoryProduct.show', compact('category_products'));
    }
}
