<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use Illuminate\Http\Request;
use App\Models\Customer;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCoupon;
use App\Models\Coupon;

class AdminCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'customer']);

            return $next($request);
        });
    }

    public function list()
    {
        $customer = Customer::select('*')->orderBy('total_spend', 'desc')->paginate(20);
        return view('admin.customer.list', compact('customer'));
    }

    public function export()
    {
        return Excel::download(new CustomersExport(), 'khachhang.xlsx');
    }

    public function sendCoupon()
    {
        $customer = Customer::all();
        $total_customer = $customer->count();
        $data_email_customer = [];
        foreach ($customer as $value) {
            $data_email_customer[] = $value->email;
        }
        $code_coupon = $this->generateRandomString(10);
        $data_coupon = [
            'code' => $code_coupon,
            'value' => 100000,
            'qty' => $total_customer,
            'status' => 'on',
        ];
        $save_coupon =  Coupon::create($data_coupon);

        if ($save_coupon) {
            $get_info_coupon = Coupon::where('id', $save_coupon->id)->first();
            $data = [
                'code_coupon' => $get_info_coupon->code,
                'value_coupon' => $get_info_coupon->value,
                'qty_coupon' => $get_info_coupon->qty,
                'email' => $data_email_customer
            ];
            $this->send_email_coupon($data);

            return redirect()->back()->with('message', 'Gửi mã khuyến mãi thành công');
        }
    }

    public function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function send_email_coupon($array)
    {
        $email = $array['email'];
        $code_coupon = $array['code_coupon'];
        $value_coupon = $array['value_coupon'];
        $qty_coupon = $array['qty_coupon'];
        $subject = "[NADSHOP - Tặng mã giảm giá] Thư tặng mã giảm giá!";
        $data = [
            'code_coupon' => $code_coupon,
            'value_coupon' => $value_coupon,
            'qty_coupon' => $qty_coupon
        ];
        Mail::to($email)->send(new SendCoupon($data, $subject));
    }
}
