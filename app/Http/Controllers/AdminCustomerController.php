<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use Illuminate\Http\Request;
use App\Models\Customer;
use Maatwebsite\Excel\Facades\Excel;

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
}
