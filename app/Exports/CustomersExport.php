<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomersExport implements FromView
{
    public function view(): View
    {
        $customer = Customer::select('*')->orderBy('total_spend', 'desc')->get();
        return view('admin.customer.export', ['customer' => $customer]);
    }
}
