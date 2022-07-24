<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomerAccount;
use App\Constants\Constants;
use App\Models\CategoryProduct;

class UserController extends Controller
{
    public function __construct(CategoryProduct $cat,)
    {
        $this->cat = $cat;
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

    public function profileEdit()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        return view('client.customer.edit', compact('category_products'));
    }
}
