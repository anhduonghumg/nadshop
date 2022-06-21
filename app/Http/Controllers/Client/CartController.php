<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Constants\Constants;
use App\Models\CategoryProduct;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\District;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Models\OrderDetail;

class CartController extends Controller
{
    protected $product;
    protected $productRepo;
    protected $city;
    protected $district;
    protected $order;
    public function __construct(
        Product $product,
        CategoryProduct $cat,
        ProductRepositoryInterface $productRepo,
        City $city,
        District $district,
        OrderRepositoryInterface $order,
        OrderDetail $orderDetail
    ) {
        $this->product = $product;
        $this->productRepo = $productRepo;
        $this->cat = $cat;
        $this->city = $city;
        $this->district = $district;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }

    public function show()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        return view('client.cart.show', compact('category_products'));
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            $variant_id = $request->product_variant;
            $product_info = ProductDetail::where('id', $variant_id)->first(['product_detail_name', 'product_price', 'product_details_thumb']);
            return response()->json($product_info);
        }
    }

    public function buy(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $product = Product::join('product_details', 'product_details.product_id', '=', 'products.id')
                ->where('products.id', $id)
                ->first();
            $list_colors = $this->productRepo->get_color_by_product($id);
            $result = [
                'product' => $product,
                'list_colors' => $list_colors,
            ];
            return response()->json($result);
        }
    }

    public function checkout()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        $list_city = $this->city->all();
        return view('client.cart.checkout', compact('category_products', 'list_city'));
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'bail|required|max:255',
            'phone' => 'bail|required|numeric',
            'address' => 'bail|required|max:255',
            'city' => 'bail|required',
            'district' => 'bail|required',
            'payment' => 'required',
            'product_name.*' => 'bail|required',
            'note' => 'max:255'
        ]);

        if ($validator->fails()) {
            $error = collect($validator->errors())->unique()->first();
            return response()->json(['errors' => $error]);
        }

        if ($request->order_qty == 0) {
            return response()->json(['errors' => trans('notification.not_select')]);
        }

        $order_code = get_order_code();
        $city = $this->city->get_name_city($request->city);
        $district = $this->district->get_name_city($request->district);
        $address = get_address($request->address, $district->district_name, $city->city_name);
        $saveDataOrder = [
            'order_code' => $order_code,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'address' => $address,
            'email' => $request->email,
            'order_qty' => $request->order_qty,
            'order_total' => $request->order_total,
            'payment' => $request->payment,
            'note' => $request->note,
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        $saveOrder = $this->order->add($saveDataOrder);
        if ($saveOrder) {
            $product_name = $request->product_name;
            foreach ($product_name as $key => $value) {
                $saveDataOrderDetail = [
                    'pro_order_qty' => $request->qty[$key],
                    'product_detail_id' => $product_name[$key],
                    'product_order_id' => $saveOrder->id
                ];
                $this->orderDetail->create($saveDataOrderDetail);
            }
            $view = route('client.thank');
            return response()->json(['success' => $view]);
        }
    }
    public function thank()
    {
        return view('client.cart.thank');
    }
}
