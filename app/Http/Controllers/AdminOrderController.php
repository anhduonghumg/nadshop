<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\OrderDetail;
use App\Models\District;
use App\Models\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ProductDetail\ProductDetailRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    protected $product;
    protected $city;
    protected $district;
    protected $order;
    protected $orderDetail;
    public function __construct(
        OrderRepositoryInterface $order,
        ProductDetailRepositoryInterface $product,
        City $city,
        OrderStatus $status,
        District $district,
        OrderDetail $orderDetail
    ) {
        $this->order = $order;
        $this->product = $product;
        $this->status = $status;
        $this->city = $city;
        $this->district = $district;
        $this->orderDetail = $orderDetail;
    }

    public function list()
    {
        $paginate = 10;
        $list_orders = $this->order->get_list_orders($paginate);
        return view('admin.order.list', compact('list_orders'));
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            $id = isset($request->product) ? $request->product : null;
            $product = $this->product->get_product_detail_by_id($id, ['product_price']);
            return response()->json(['product' => $product]);
        }
        $list_city = $this->city->all();
        $list_status = $this->status->all();
        $list_product =  $this->product->get('id', 'product_detail_name');
        return view('admin.order.add', compact('list_city', 'list_status', 'list_product'));
    }

    public function loadDistrict(Request $request)
    {
        if ($request->ajax()) {
            $id_city = $request->city;
            $list_district = District::where('city_id', $id_city)->get();
            return view('admin.order.district', compact('list_district'))->render();
        }
    }

    public function addProduct(Request $request)
    {
        if ($request->ajax()) {
            $list_product = $this->product->get('id', 'product_detail_name');
            $result = [
                'list_product' => $list_product
            ];
            return response()->json($result);
        }
    }

    public function detail(Request $request)
    {
        if ($request->ajax()) {
            // $id = $request->order;
            // $info_orders = get_info_order($id);
            // $list_product_order = get_product_orders($id);

            // return view('admin.order.detail', compact('info_orders', 'list_product_order'))->render();

            return 1;
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'fullname' => 'bail|required|max:255',
                'phone' => 'bail|required|numeric',
                'email' => 'bail|required|email',
                'address' => 'bail|required|max:255',
                'city' => 'bail|required',
                'district' => 'bail|required',
                'order_status' => 'bail|required',
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
            $saveDataOrder = [
                'order_code' => $order_code,
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $city->city_name,
                'district' => $district->district_name,
                'order_qty' => $request->order_qty,
                'order_total' => $request->order_total,
                'order_status' => $request->order_status,
                'payment' => $request->payment,
                'note' => $request->note,
                'user_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ];

            $saveOrder = $this->order->add($saveDataOrder);

            if ($saveOrder) {
                foreach ($request->product_name as $key => $value) {
                    $saveDataOrderDetail = [
                        'pro_order_qty' => $request->qty[$key],
                        'product_detail_id' => $request->product_name[$key],
                        'product_order_id' => $saveOrder->id
                    ];
                    $this->orderDetail->create($saveDataOrderDetail);
                }

                return response()->json(['success' => trans('notification.add_success')]);
            }
        }
    }
}
