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
use Illuminate\Support\Facades\Validator;
use App\Models\Rating;
use App\Models\OrderDetail;
use Illuminate\Support\Carbon;
use App\Models\View;

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
        $rating = Rating::where('product_id', $pro_id)->avg('rating');
        $rating = round($rating);
        $count_rating = Rating::where('product_id', $pro_id)->count();

        $view_product = View::where('product_id', $pro_id)->first();
        $now = now();
        if ($view_product) {
            if ($view_product->date_view == $now->format('Y-m-d')) {
                $view_product->view = $view_product->view + 1;
                $view_product->save();
            } else {
                $new_date_view = new View();
                $new_date_view->product_id = $pro_id;
                $new_date_view->date_view = $now;
                $new_date_view->view = 1;
                $new_date_view->save();
            }
        } else {
            $view_product = new View();
            $view_product->product_id = $pro_id;
            $view_product->date_view = $now;
            $view_product->view = 1;
            $view_product->save();
        }

        return view('client.product.detail', compact('product', 'category_products', 'list_colors', 'pro_id', 'rating', 'count_rating'));
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
                ->where('product_status', Constants::PUBLIC)
                ->where('products.deleted_at', '=', Constants::EMPTY)
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
            $list_comment = Comment::where('comment_product_id', $id)->where('comment_status', 1)->where('comment_parent', 0)->orderByDesc('id')->get();
            $sub_comment = Comment::where('comment_product_id', $id)->where('comment_status', 1)->where('comment_parent', '>', 0)->orderByDesc('id')->get();
            $total_comment = $list_comment->count();
            $view = view('client.product.comment', compact('list_comment', 'total_comment', 'sub_comment'))->render();
            return response()->json($view);
        } else {
            return redirect()->route('client.home');
        }
    }

    public function add_comment(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'comment' => 'bail|required|string',
                'comment_name' => 'bail|required|string'
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $saveData = [
                'comment' => $request->comment,
                'comment_name' => $request->comment_name,
                'comment_status' => 0,
                'comment_product_id' => $request->id_product,
                'comment_date' => now(),
                'comment_parent' => 0
            ];

            Comment::create($saveData);
            return response()->json(['success' => trans('notification.add_success')]);
        }
    }

    public function load_comment(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id ? (int)$request->id : '';
            $list_comment = Comment::where('comment_product_id', $id)->where('comment_status', 1)->where('comment_parent', 0)->orderByDesc('id')->get();
            $sub_comment = Comment::where('comment_product_id', $id)->where('comment_status', 1)->where('comment_parent', '>', 0)->orderByDesc('id')->get();
            $total_comment = $list_comment->count();
            $view = view('client.product.comment', compact('list_comment', 'total_comment', 'sub_comment'))->render();
            return response()->json($view);
        } else {
            return redirect()->route('client.home');
        }
    }
    public function rating(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $rating = new Rating();
            $rating->product_id = $data['product_id'];
            $rating->rating = $data['index'];
            $rating->save();
            return response()->json(['success' => "Bạn đã đánh giá sản phẩm {$request->index} sao"]);
        }
    }

    public function rank(Request $request)
    {
        if ($request->ajax()) {
            $select = $request->select;
            $now = Carbon::now()->format('d-m-Y');
            $day = Carbon::createFromFormat('d-m-Y', $now)->format('Y-m-d');
            $week = now()->subDays(7)->format('Y-m-d');
            $month = now()->subDays(30)->format('Y-m-d');
            if ($select === 'day') {
                $product = OrderDetail::selectRaw('products.product_name,product_details.product_price,product_details.product_details_thumb,product_details.product_discount,SUM(product_order_details.pro_order_qty) as sell')
                    ->join('product_orders', 'product_order_details.product_order_id', '=', 'product_orders.id')
                    ->join('product_details', 'product_order_details.product_detail_id', '=', 'product_details.id')
                    ->join('products', 'product_details.product_id', '=', 'products.id')
                    ->where('product_orders.order_date', '=', $day)
                    ->groupBy('products.product_name')
                    ->orderBy('sell', 'DESC')
                    ->take(10)
                    ->get();
            } elseif ($select === 'week') {
                $product = OrderDetail::selectRaw('products.product_name,product_details.product_price,product_details.product_details_thumb,product_details.product_discount,SUM(product_order_details.pro_order_qty) as sell')
                    ->join('product_orders', 'product_order_details.product_order_id', '=', 'product_orders.id')
                    ->join('product_details', 'product_order_details.product_detail_id', '=', 'product_details.id')
                    ->join('products', 'product_details.product_id', '=', 'products.id')
                    ->whereBetween('product_orders.order_date', [$week, $day])
                    ->groupBy('products.product_name')
                    ->orderBy('sell', 'DESC')
                    ->take(10)
                    ->get();
            } elseif ($select === 'month') {
                $product = OrderDetail::selectRaw('products.product_name,product_details.product_price,product_details.product_details_thumb,product_details.product_discount,SUM(product_order_details.pro_order_qty) as sell')
                    ->join('product_orders', 'product_order_details.product_order_id', '=', 'product_orders.id')
                    ->join('product_details', 'product_order_details.product_detail_id', '=', 'product_details.id')
                    ->join('products', 'product_details.product_id', '=', 'products.id')
                    ->whereBetween('product_orders.order_date', [$month, $day])
                    ->groupBy('products.product_name')
                    ->orderBy('sell', 'DESC')
                    ->take(10)
                    ->get();
            }
            $list_product = $product;
            $view = view('client.rank.best_sell', compact('list_product'))->render();
            return response()->json($view);
        }
    }

    public function rankTopView(Request $request)
    {
        if ($request->ajax()) {
            $select = $request->select;
            $now = Carbon::now()->format('d-m-Y');
            $day = Carbon::createFromFormat('d-m-Y', $now)->format('Y-m-d');
            $week = now()->subDays(7)->format('Y-m-d');
            $month = now()->subDays(30)->format('Y-m-d');
            if ($select === 'dayview') {
                $product = View::selectRaw('products.id,products.product_name,SUM(product_views.view) as view,product_details.product_details_thumb,product_details.product_price,product_details.product_discount')
                    ->join('products', 'products.id', '=', 'product_views.product_id')
                    ->join('product_details', 'product_details.product_id', '=', 'products.id')
                    ->where('products.product_status', '=', 'public')
                    ->where('product_views.date_view', $day)
                    ->groupBy('products.product_name')
                    ->orderBy('view', 'DESC')
                    ->take(10)
                    ->get();
            } elseif ($select === 'weekview') {
                $product = View::selectRaw('products.id,products.product_name,SUM(product_views.view) as view,product_details.product_details_thumb,product_details.product_price,product_details.product_discount')
                    ->join('products', 'products.id', '=', 'product_views.product_id')
                    ->join('product_details', 'product_details.product_id', '=', 'products.id')
                    ->where('products.product_status', '=', 'public')
                    ->whereBetween('product_views.date_view', [$week, $day])
                    ->groupBy('products.product_name')
                    ->orderBy('view', 'DESC')
                    ->take(10)
                    ->get();
            } elseif ($select === 'monthview') {
                $product = View::selectRaw('products.id,products.product_name,SUM(product_views.view) as view,product_details.product_details_thumb,product_details.product_price,product_details.product_discount')
                    ->join('products', 'products.id', '=', 'product_views.product_id')
                    ->join('product_details', 'product_details.product_id', '=', 'products.id')
                    ->where('products.product_status', '=', 'public')
                    ->whereBetween('product_views.date_view', [$month, $day])
                    ->groupBy('products.product_name')
                    ->orderBy('view', 'DESC')
                    ->take(10)
                    ->get();
            }
        }
        $list_product = $product;
        $view = view('client.rank.top_view', compact('list_product'))->render();
        return response()->json($view);
    }
}
