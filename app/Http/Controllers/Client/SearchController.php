<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Constants\Constants;
use App\Models\Product;
use Illuminate\Support\Arr;
use App\Models\Color;
use App\Models\Size;

class SearchController extends Controller
{
    public function __construct(CategoryProduct $cat)
    {
        $this->cat = $cat;
    }

    public function show(Request $request)
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        $kw = $request->key ? $request->key : '';
        $list_product = Product::select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price', 'product_details.product_discount')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->where('products.product_name', 'like', "%{$kw}%")
            ->where('products.product_status', Constants::PUBLIC)
            ->where('products.deleted_at', Constants::EMPTY)
            ->orderByDesc('products.id')
            ->distinct()
            ->paginate(10);
        $count = count($list_product);
        $list_color = Color::all();
        $list_size = Size::all();
        return view('client.search.show', compact('category_products', 'list_product', 'count', 'list_color', 'list_size', 'list_color'));
    }

    public function searchAjax(Request $request)
    {
        if ($request->ajax()) {
            $key = $request->key ? $request->key : '';
            $color = $request->color_filter;
            $size = $request->size_filter;
            $price = $request->price_filter;
            $sort_by = isset($request->sort_by) ? $request->sort_by : 'new';
            $list_product = Product::select('products.id', 'products.product_name', 'product_details.product_price', 'products.product_thumb', 'product_details.product_discount')
                ->join('product_details', 'product_details.product_id', '=', 'products.id')
                ->where('products.product_status', Constants::PUBLIC)
                ->where('products.deleted_at', Constants::EMPTY)
                ->distinct();

            if (!empty($key)) {
                $list_product->where('products.product_name', 'like', "%{$key}%");
            }

            if (!empty($color)) {
                $color_filter = Arr::flatten($color);
                $list_product = $list_product->whereIn('product_details.color_id', $color_filter);
            }

            if (!empty($size)) {
                $size_filter = Arr::flatten($size);
                $list_product = $list_product->whereIn('product_details.size_id', $size_filter);
            }

            if (!empty($price)) {
                $list_product->where(function ($query) {
                    $query->when(in_array('0', request()->price_filter), function ($query) {
                        $query->orWhere('product_details.product_price', '<', '200000');
                    })
                        ->when(in_array('1', request()->price_filter), function ($query) {
                            $query->orWhereBetween('product_details.product_price', ['200000', '500000']);
                        })
                        ->when(in_array('2', request()->price_filter), function ($query) {
                            $query->orWhereBetween('product_details.product_price', ['500000', '1000000']);
                        })
                        ->when(in_array('3', request()->price_filter), function ($query) {
                            $query->orWhere('product_details.product_price', '>', '1000000');
                        });
                });
            }

            if ($sort_by == 'new') {
                $list_product = $list_product->orderByDesc('products.id');
            } elseif ($sort_by == 'priceDesc') {
                $list_product = $list_product->orderByDesc('product_details.product_price');
            } elseif ($sort_by == 'priceAsc') {
                $list_product = $list_product->orderBy('product_details.product_price', 'asc');
            }

            $list_product = $list_product->get();
            // $view = view('client.search.showajax', compact('list_product'))->render();
            $result = [
                'list_product' => $list_product
            ];
            return response()->json($result);
        }
    }

    public function searchAutoCompalte(Request $request)
    {
        if ($request->ajax()) {
            $key = $request->search_text ? $request->search_text : 'null';
            $list_product = Product::select('products.id', 'products.product_name', 'product_details.product_price', 'product_details.product_details_thumb', 'product_details.product_discount')
                ->join('product_details', 'product_details.product_id', '=', 'products.id')
                ->where('products.product_name', 'like', "%{$key}%")
                ->where('products.product_status', '=', 'public')
                ->orderByDesc('products.id')
                ->distinct()
                ->take(5)
                ->get();
            $view = view('client.search.autoajax', compact('list_product', 'key'))->render();
            return response()->json($view);
        }
    }
}
