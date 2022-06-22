<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Constants\Constants;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $order;
    public function __construct(CategoryProduct $cat,  OrderRepositoryInterface $order)
    {
        $this->cat = $cat;
        $this->order = $order;
    }
    public function find()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        return view('client.order.check', compact('category_products'));
    }

    public function show(Request $request)
    {
        $error = [];
        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
        ]);

        if ($validator->fails()) {
            $error['validate'] = collect($validator->errors())->unique()->first();
            return response()->json(['errors' => $error['validate']]);
        }

        $order_code = $request->order_code;
        $check = $this->order->check_order($order_code);
        if (!$check) {
            $error['required'] = "Mã đơn hàng không tồn tại trong hệ thống.";
            return response()->json(['errors' => $error['required']]);
        } else {
            $orders = $this->order->get_order($order_code);
            return response()->json(['order' => $orders]);
        }
    }
}
