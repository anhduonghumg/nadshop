<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomerAccount;
use App\Constants\Constants;
use App\Models\CategoryProduct;
use App\Models\Order;
use Illuminate\Support\Carbon;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Models\OrderDetail;

class UserController extends Controller
{
    protected $order;
    protected $orderDetail;
    public function __construct(
        CategoryProduct $cat,
        OrderRepositoryInterface $order,
        OrderDetail $orderDetail
    ) {
        $this->cat = $cat;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }

    public function login(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'email' => 'bail|required',
                'password' => 'bail|required|string',
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $email = $request->email;
            $password = md5($request->password);
            $url = $request->current_url;
            $check = CustomerAccount::where('email', $email)->where('password', $password)->first();
            if ($check) {
                session()->put('client_login', true);
                session()->put('client_name', $check->fullname);
                session()->put('client_id', $check->id);

                return response()->json(['success' => $url]);
            } else {
                return response()->json(['errors' => 'Email hoặc mật khẩu không đúng.Xin hãy nhập lại!']);
            }
        }
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('client_login')) {
            $request->session()->forget('client_login');
            $request->session()->forget('client_name');
            $request->session()->forget('client_id');

            return redirect()->route('client.home');
        }
    }

    public function register(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'fullname' => 'bail|required|string',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'email' => 'bail|required|email|unique:customers',
                'password' => 'bail|required|regex:/^([\w_\.!@#$%^&*()]+){5,32}$/',

            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $create_account = [
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => md5($request->password)
            ];

            CustomerAccount::create($create_account);
            return response()->json(['success' => 'Đăng ký tài khoản thành công.']);
        }
    }

    public function profile()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        return view('client.customer.profile', compact('category_products'));
    }

    public function profileEdit(Request $request)
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        if ($request->session()->has('client_login')) {
            $id = $request->session()->get('client_id');
            $customer = CustomerAccount::where('id', $id)->first();
        }
        return view('client.customer.edit', compact('category_products', 'customer'));
    }

    public function profileUpdate(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'fullname' => 'bail|required|max:255',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'birthday' => 'bail|required|string',
                'address' => 'bail|required|string',
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }
            $id = (int)$request->id;
            $birthday = Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d');
            $update_info = [
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'birthday' => $birthday,
                'address' => $request->address,
            ];

            CustomerAccount::where('id', $id)->update($update_info);
            return response()->json(['success' => 'Cập nhập thông tin thành công']);
        }
    }

    public function profileChangePass(Request $request)
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        if ($request->session()->has('client_login')) {
            $id = $request->session()->get('client_id');
            $customer = CustomerAccount::where('id', $id)->first();
        }
        return view('client.customer.changePass', compact('category_products', 'customer'));
    }

    public function changePass(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'old_pass' => 'bail|required|regex:/^([\w_\.!@#$%^&*()]+){5,32}$/',
                'new_pass' => 'bail|required|regex:/^([\w_\.!@#$%^&*()]+){5,32}$/',
                'confirm_pass' => 'bail|required|same:new_pass|regex:/^([\w_\.!@#$%^&*()]+){5,32}$/',
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $id = (int)$request->id;
            $password = CustomerAccount::select('password')->where('id', $id)->first();
            $old_password = md5($request->old_pass);
            $new_pass = md5($request->new_pass);
            if ($password->password != $old_password) {
                return response()->json(['errors' => 'Mật khẩu cũ không đúng.Xin kiểm tra lại']);
            }

            if ($password->password == $new_pass) {
                return response()->json(['errors' => 'Mật khẩu mới không nên giống với mật khẩu cũ']);
            }

            $data = [
                'password' => $new_pass
            ];

            CustomerAccount::where('id', $id)->update($data);
            return response()->json(['success' => 'Thay đổi mật khẩu thành công']);
        }
    }

    public function orderHistory(Request $request)
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        if ($request->session()->has('client_login')) {
            $id = $request->session()->get('client_id');
        }
        $order_history = Order::select('id', 'order_code', 'order_total', 'order_status', 'order_date', 'customer_account_id')
            ->where('customer_account_id', $id)
            ->orderBy('order_date', 'desc')
            ->paginate(20);
        return  view('client.customer.orderHistory', compact('category_products', 'order_history'));
    }

    public function orderDetail(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->order;
            $info_orders = $this->order->get_info_order($id);
            $list_product_order = $this->orderDetail->get_product_order($id);
            $view = view('client.customer.detail', compact('info_orders', 'list_product_order'))->render();
            return response()->json($view);
        }
    }

    public function orderCancel(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $view = view('client.customer.orderCancel', compact('id'))->render();
            return response()->json($view);
        }
    }

    public function orderCancelConfirm(Request $request)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'note' => 'bail|required|string',
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
