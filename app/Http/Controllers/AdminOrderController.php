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
use App\Constants\Constants;
use App\Models\Customer;

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

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $keyword = isset($request->kw) ? $request->kw : null;
            $status = isset($request->status) ? $request->status : null;
            $get_list_order = $this->order->get_list_order();
            $get_list_order = collect($get_list_order);
            $list_status = [
                'pending' => 'Chờ xác nhận',
                'shipping' => 'Vận chuyển',
                'success' => 'Hoàn thành',
                'cancel' => 'Hủy bỏ',
                'delete' => 'Xóa'
            ];
            if ($status != null) {
                $list_orders = $get_list_order->where('order_status', $status)
                    ->filter(function ($value) use ($keyword) {
                        return strstr($value['order_code'], $keyword, true) ||
                            stripos($value['fullname'], $keyword, true);
                    });
            } else {
                $list_orders = $get_list_order->filter(function ($value) use ($keyword) {
                    return strstr($value['order_code'], $keyword, true) ||
                        stripos($value['fullname'], $keyword, true);
                });
            }
            $list_status = collect($list_status);
            if ($status == Constants::PENDING) {
                $act = $list_status->only(Constants::SHIPPING, Constants::CANCEL);
            } elseif ($status == Constants::SHIPPING) {
                $act = $list_status->only(Constants::SUCCESS, Constants::CANCEL);
            } elseif ($status == Constants::SUCCESS) {
                $act = $list_status->only(Constants::DELETE);
            } elseif ($status == Constants::CANCEL) {
                $act = $list_status->only(Constants::DELETE);
            } else {
                $act = $list_status->only(Constants::DELETE);
            }
            $list_orders = $list_orders->paginate(Constants::PAGINATE);
            $list_action = $act;
            $success = $this->order->count_order($get_list_order, Constants::SUCCESS);
            $pending = $this->order->count_order($get_list_order, Constants::PENDING);
            $shipping = $this->order->count_order($get_list_order, Constants::SHIPPING);
            $cancel = $this->order->count_order($get_list_order, Constants::CANCEL);
            $data_num_order = [
                'success' => $success,
                'pending' => $pending,
                'shipping' => $shipping,
                'cancel' => $cancel,
            ];
            return view('admin.order.listajax', compact('list_orders', 'data_num_order', 'list_action', 'data_num_order'))->render();
        }
        $get_list_order = $this->order->get_list_order();
        $get_list_order = collect($get_list_order);
        $status = isset($request->status) ? $request->status : null;
        $path = isset($request->status) ? "?status=" . $request->status : null;
        $list_status = [
            'pending' => 'Chờ xác nhận',
            'shipping' => 'Vận chuyển',
            'success' => 'Hoàn thành',
            'cancel' => 'Hủy bỏ',
            'delete' => 'Xóa'
        ];
        $list_status = collect($list_status);
        if ($status == Constants::PENDING) {
            $act = $list_status->only(Constants::SHIPPING, Constants::CANCEL);
            $list_orders = $get_list_order->where('order_status', Constants::PENDING);
        } elseif ($status == Constants::SHIPPING) {
            $act = $list_status->only(Constants::SUCCESS, Constants::CANCEL);
            $list_orders = $get_list_order->where('order_status', Constants::SHIPPING);
        } elseif ($status == Constants::SUCCESS) {
            $act = $list_status->only(Constants::DELETE);
            $list_orders = $get_list_order->where('order_status', Constants::SUCCESS);
        } elseif ($status == Constants::CANCEL) {
            $act = $list_status->only(Constants::DELETE);
            $list_orders = $get_list_order->where('order_status', Constants::CANCEL);
        } else {
            $act = $list_status->only(Constants::DELETE);
            $list_orders = $get_list_order;
        }
        $list_action = $act;
        $list_orders = $list_orders->paginate(Constants::PAGINATE)->withPath($path);
        $all = $get_list_order->count();
        $success = $this->order->count_order($get_list_order, Constants::SUCCESS);
        $pending = $this->order->count_order($get_list_order, Constants::PENDING);
        $shipping = $this->order->count_order($get_list_order, Constants::SHIPPING);
        $cancel = $this->order->count_order($get_list_order, Constants::CANCEL);
        $data_num_order = [
            'all' => $all,
            'success' => $success,
            'pending' => $pending,
            'shipping' => $shipping,
            'cancel' => $cancel,
        ];

        return view('admin.order.list', compact('list_orders', 'data_num_order', 'list_action'));
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            $id = isset($request->product) ? $request->product : null;
            $product = $this->product->get_product_detail_by_id($id, ['product_price', 'cost_price']);
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
            $id = (int)$request->order;
            $info_orders = $this->order->get_info_order($id);
            $list_product_order = $this->orderDetail->get_product_order($id);

            return view('admin.order.detail', compact('info_orders', 'list_product_order'))->render();
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
            $address = get_address($request->address, $district->district_name, $city->city_name);
            $saveDataOrder = [
                'order_code' => $order_code,
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'address' => $address,
                'email' => $request->email,
                'order_qty' => $request->order_qty,
                'order_total' => $request->order_total,
                'order_profit' => $request->profit,
                'order_status' => $request->order_status,
                'payment' => $request->payment,
                'note' => $request->note,
                'order_date' => now()->format('Y/m/d'),
                'user_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ];

            $saveOrder = $this->order->add($saveDataOrder);
            $check_customer = Customer::where('fullname', $request->fullname)->where('phone', $request->phone)->first();
            if ($check_customer) {
                $data_customer = [
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'address' => $address,
                    'phone' => $request->phone,
                    'total_order' => (int)$request->order_qty + (int)$check_customer->total_order,
                    'total_spend' => (int)$request->order_total + (int)$check_customer->total_spend,
                ];
                Customer::where('id', $check_customer->id)->update($data_customer);
            } else {
                $data_customer = [
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'address' => $address,
                    'phone' => $request->phone,
                    'total_order' => (int)$request->order_qty,
                    'total_spend' => (int)$request->order_total,
                ];
                Customer::create($data_customer);
            }

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
                return response()->json(['success' => trans('notification.add_success')]);
            }
        }
    }


    public function edit(Request $request, $id)
    {
        $order = $this->order->find($id);
        $list_city = $this->city->all();
        $list_status = $this->status->all();
        $product_order =  $this->orderDetail->get_product_order($id);

        return view('admin.order.edit', compact('list_city', 'list_status', 'order', 'product_order'));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $validator = Validator::make($request->all(), [
                'fullname' => 'bail|required|max:255',
                'phone' => 'bail|required|numeric',
                'email' => 'bail|email|max:255',
                'address' => 'bail|required|max:255',
                //'order_status' => 'bail|required',
                'note' => 'max:255'
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $saveDataOrder = [
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'address' => $request->address,
                'note' => $request->note,
                'email' => $request->email,
                'user_id' => Auth::id(),
                'updated_at' => now()
            ];

            $saveOrder = $this->order->update($saveDataOrder, $id);
            if ($saveOrder) {
                return response()->json(['success' => trans('notification.update_success')]);
            }
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $delete_order = $this->order->forceDelete($id);
            if ($delete_order) {
                $this->orderDetail->delete_order($id);
                return response()->json(['success' => trans('notification.force_delete_success')]);
            }
        }
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            $list_check = $request->list_check;
            if (!empty($list_check)) {
                $act = $request->act;
                if ($act == Constants::SHIPPING) {
                    $data = ['order_status' => Constants::SHIPPING];
                    $this->order->update($data, $list_check);
                    return response()->json(['success' => trans('notification.update_order')]);
                } elseif ($act == Constants::SUCCESS) {
                    $data = ['order_status' => Constants::SUCCESS];
                    $this->order->update($data, $list_check);
                    return response()->json(['success' => trans('notification.update_order')]);
                } elseif ($act == Constants::CANCEL) {
                    $data = ['order_status' => Constants::CANCEL];
                    $this->order->update($data, $list_check);
                    return response()->json(['success' => trans('notification.update_order')]);
                } elseif ($act == Constants::DELETE) {
                    $this->order->forceDelete($list_check);
                    return response()->json(['success' => trans('notification.update_order')]);
                } elseif (empty($act)) {
                    return response()->json(['errors' => trans('notification.not_action')]);
                }
            } else {
                return response()->json(['errors' => trans('notification.not_element')]);
            }
        }
    }
}
