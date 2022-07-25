<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Constants\Constants;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderDetail;
use App\Models\Order;

class OrderController extends Controller
{
    protected $order;
    protected $orderDetail;
    public function __construct(CategoryProduct $cat,  OrderRepositoryInterface $order, OrderDetail $orderDetail)
    {
        $this->cat = $cat;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
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

    public function detail(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->order;
            $info_orders = $this->order->get_info_order($id);
            $list_product_order = $this->orderDetail->get_product_order($id);
            $view = view('client.order.detail', compact('info_orders', 'list_product_order'))->render();
            return response()->json($view);
        }
    }

    public function cancel(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $view = view('client.order.cancel', compact('id'))->render();
            return response()->json($view);
        }
    }

    public function confirm(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'note' => 'required',
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $id = (int)$request->id;
            $note = $request->note;
            $data = [
                'note' => $note,
                'order_status' => 'cancel'
            ];

            Order::where('id', $id)->update($data);
            return response()->json(['success' => 'Hủy đơn hàng thành công']);
        }
    }
}
