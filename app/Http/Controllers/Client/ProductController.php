<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Constants\Constants;
use Illuminate\Support\Arr;

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

    public function load_product(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $list_product = $this->product->select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price')
                ->join('product_details', 'products.id', '=', 'product_details.product_id')
                ->where('products.product_cat_id', $id)
                ->orderByDesc('products.id')
                ->distinct()
                ->take(8)
                ->get();
            return view('client.product.load', compact('list_product'))->render();
        }
    }

    public function filter(Request $request)
    {
        if ($request->ajax()) {

            $id = isset($request->cat_id) ? (int)$request->cat_id : null;
            $color = $request->color_filter;
            $size = $request->size_filter;
            $sort_by = isset($request->sort_by) ? $request->sort_by : 'new';
            $list_product = Product::select('products.id', 'products.product_name', 'product_details.product_price', 'products.product_thumb')
                ->join('product_details', 'product_details.product_id', '=', 'products.id')
                ->where('products.product_cat_id', $id)
                ->distinct();
            // $list_product->when($request->color_filter != null, function ($q) {
            //     return $q->whereIn('likes', '>', request('likes_amount', 0));
            // });
            // $list_product->when($request->size_filter != null, function ($q) {
            //     return $q->whereIn('created_at', request('ordering_rule', 'desc'));
            // });
            // $list_products = $list_product->get();
            // $list_product = Product::query();
            if (!empty($color)) {
                $color_filter = Arr::flatten($color);
                $list_product = $list_product->whereIn('product_details.color_id', $color_filter);
            }

            if (!empty($size)) {
                $size_filter = Arr::flatten($size);
                $list_product = $list_product->whereIn('product_details.size_id', $size_filter);
            }

            // if (!empty($price)) {
            //     $price_filter = $list_product->whereIn(function ($q) {
            //         $q->whereBetween('price', [0, 199999]);
            //     });
            // }

            if ($sort_by == 'new') {
                $list_product = $list_product->orderByDesc('products.id');
            } elseif ($sort_by == 'priceDesc') {
                $list_product = $list_product->orderByDesc('product_details.product_price');
            } elseif ($sort_by == 'priceAsc') {
                $list_product = $list_product->orderBy('product_details.product_price', 'asc');
            }

            $list_product = $list_product->get();
            $result = [
                // 'route' => route('client.product.detail'),
                'list_product' => $list_product
            ];
            return response()->json($result);
        }
    }
}
