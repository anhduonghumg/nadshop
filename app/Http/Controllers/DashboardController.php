<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistical;

class DashboardController extends Controller
{
    function index()
    {
        return view('admin.dashboard');
    }

    function filter_by_date(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $from_date = $data['from_date'];
            $to_date = $data['to_date'];

            $get = Statistical::whereBetween('date', [$from_date, $to_date])
                ->orderBy('date', 'ASC')
                ->get();

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->date,
                    'order' => $val->total_order,
                    'sales' => $val->sales,
                    'profit' => $val->profit,
                    'qty' => $val->qty,
                );
            }
            echo $data = json_encode($chart_data);
        }
    }
}
