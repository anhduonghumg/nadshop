<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Constants\Constants;
use Illuminate\Support\Arr;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Models\Color;
use App\Models\Comment;

class ProductController extends Controller
{
    protected $product;
    protected $productRepo;
    public function __construct(
        Product $product,
        CategoryProduct $cat,
        ProductRepositoryInterface $productRepo
    ) {
        $this->product = $product;
        $this->productRepo = $productRepo;
        $this->cat = $cat;
    }

    public function detail($id)
    {
        $pro_id = (int)$id;
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        $product = $this->product
            ->join('product_details', 'product_details.product_id', '=', 'products.id')
            ->where('products.id', $pro_id)
            ->first();
        $list_colors = $this->productRepo->get_color_by_product($id);
        $view = $product->views;
        $view = $view + 1;
        $data = ['views' => $view];
        $this->product->where('products.id', $pro_id)->update($data);
        // $list_size = $this->product->get_size_by_product();
        return view('client.product.detail', compact('product', 'category_products', 'list_colors', 'pro_id'));
    }

    public function variant(Request $request)
    {
        if ($request->ajax()) {
            $color = (int)$request->id_color;
            $product = (int)$request->id_product;

            $size_by_color = $this->productRepo->get_size_by_product($color, $product);
            $color = Color::find($color);

            $result = [
                'size' => $size_by_color,
                'color_name' => $color->color_name
            ];

            return response()->json($result);
        }
    }

    public function change(Request $request)
    {
        if ($request->ajax()) {
            $variant = (int)$request->product_variant;
            $product = (int)$request->product;

            $result = [
                'variant_id' => $variant,
                'pro_id' => $product
            ];

            return response()->json($result);
        }
    }

    public function wishlist()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        return view('client.product.wishlist', compact('category_products'));
    }

    public function load_product(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $list_product = $this->product->select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price', 'product_details.product_discount')
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
            $price = $request->price_filter;
            $sort_by = isset($request->sort_by) ? $request->sort_by : 'new';
            $list_product = Product::select('products.id', 'products.product_name', 'product_details.product_price', 'products.product_thumb', 'product_details.product_discount')
                ->join('product_details', 'product_details.product_id', '=', 'products.id')
                ->where('products.product_cat_id', $id)
                ->distinct();

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
            $result = [
                'list_product' => $list_product
            ];
            return response()->json($result);
        }
    }

    public function show_comment(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id_product ? (int)$request->id_product : '';
            $list_comment = Comment::where('comment_product_id', $id)->get();
            $total_comment = $list_comment->count();
            $view = view('client.product.comment', compact('list_comment', 'total_comment'))->render();
            return response()->json($view);
        } else {
            return redirect()->route('client.home');
        }
    }
}
