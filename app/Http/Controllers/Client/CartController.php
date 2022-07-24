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
use App\Jobs\SendOrderEmail;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Customer;

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
            $product_info = ProductDetail::where('id', $variant_id)->first(['product_detail_name', 'product_price', 'product_details_thumb', 'product_discount', 'cost_price']);
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

        if ($request->session()->has('client_login') && $request->session()->get('client_login') == true) {
            $customer_id = $request->session()->get('client_id');
        } else {
            $customer_id = null;
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
            'order_date' => now()->format('Y/m/d'),
            'order_total' => $request->order_total,
            'order_profit' => $request->profit,
            'payment' => $request->payment,
            'customer_account_id' => $customer_id,
            'note' => $request->note,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $saveOrder = $this->order->add($saveDataOrder);

        // Thêm khách hàng
        $check_customer = Customer::where('fullname', $request->fullname)->where('email', $request->email)->first();
        if (!$check_customer) {
            $data_customer = [
                'fullname' => $request->fullname,
                'email' => $request->email,
                'address' => $address,
                'phone' => $request->phone,
                'total_order' => 0,
                'total_spend' => 0,
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

            $details['email'] = $request->email;
            $emailJob = new SendOrderEmail($details);
            dispatch($emailJob);
            $code = Str::after($order_code, '#');
            $view = route('client.thank', $code);
            return response()->json(['success' => $view]);
        }
    }

    public function thank(Request $request)
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        $code = $request->code;
        $check = $this->order->check_code($code);
        if ($check) {
            return view('client.cart.thank', compact('category_products', 'code'));
        } else {
            return redirect()->route('client.home');
        }
    }

    public function changePayment(Request $request)
    {
        if ($request->ajax()) {
            $payment = $request->payment;
            if ($payment == 'vnpay') {
                $html = "<button type='button' name='redirect'
                class='btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3 btn_vnpay'>Thanh
                toán VNPAY
            </button>";
            } else {
                $html = '<button type="button" name="btn_add_order"
                class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3 btn_complate_order">Thanh
                toán COD
            </button>';
            }
            return $html;
        }
    }

    public function vnpayPayment(Request $request)
    {
        if ($request->ajax()) {
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

            if ($request->session()->has('client_login') && $request->session()->get('client_login') == true) {
                $customer_id = $request->session()->get('client_id');
            } else {
                $customer_id = null;
            }

            // Thêm đơn hàng
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
                'payment' => $request->payment,
                'order_date' => now()->format('Y/m/d'),
                'is_paid' => 0,
                'customer_account_id' => $customer_id,
                'note' => $request->note,
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
            }

            // Thêm khách hàng
            $check_customer = Customer::where('fullname', $request->fullname)->where('email', $request->email)->first();
            if (!$check_customer) {
                $data_customer = [
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'address' => $address,
                    'phone' => $request->phone,
                    'total_order' => 0,
                    'total_spend' => 0,
                ];
                Customer::create($data_customer);
            }



            // Thanh toán online
            $order_code = get_order_code();
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('check_vnpay');
            $vnp_TmnCode = "U25HD9I9"; //Mã website tại VNPAY 
            $vnp_HashSecret = "SJOHIHMOWXQXENHWOINIHFBIDYRLVWLL"; //Chuỗi bí mật

            $vnp_TxnRef = $order_code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = 'Thanh toán online test';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $request->order_total * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00', 'message' => 'success', 'data' => $vnp_Url
            );
            return response()->json($vnp_Url);
        }
    }

    public function checkVnpay()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        return view('client.cart.check', compact('category_products'));
    }

    public function confirmVnpay(Request $request)
    {
        if ($request->ajax()) {
            $order_code = $request->order_code;
            $transaction = $request->transaction;
            $code = $order_code;
            if ($transaction == '00') {
                $saveDataOrder = [
                    'is_paid' => 1,
                    'order_status' => 'shipping'
                ];
                Order::where('order_code', $order_code)->update($saveDataOrder);

                $view = view('client.cart.success', compact('code'))->render();
                return response()->json(['success' => $view], 201);
            } else {
                $order = Order::select('id')->where('order_code', $order_code)->first();
                $id = $order->id;
                Order::where('id', $id)->delete();
                OrderDetail::where('product_order_id', $id)->delete();
                $view = view('client.cart.fail', compact('code'))->render();
                return response()->json(['errors' => $view], 202);
            }
        }
    }
}
