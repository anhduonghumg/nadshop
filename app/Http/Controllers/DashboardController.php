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
            // $data = $chart_data;
            $data = json_encode($chart_data);
            return $data;
        }
    }

    function filter(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $first_day_this_month = now()->startOfMonth()->format('d/m/Y');
            $early_last_month = now()->subMonth()->startOfMonth()->format('d/m/Y');
            $end_last_month = now()->subMonth()->endOfMonth()->format('d/m/Y');
            $last_week = now()->subDays(7)->format('d/m/Y');
            $last_year = now()->subDays(20)->format('d/m/Y');
            $now = now()->format('d/m/Y');
            if ($data['filter'] == 'lastWeek') {
                $get = Statistical::whereBetween('date', [$last_week, $now])
                    ->orderBy('date', 'ASC')
                    ->get();
                // return response()->json(['rs' => $now]);
            } elseif ($data['filter'] == 'lastMonth') {
                $get = Statistical::whereBetween('date', [$early_last_month, $end_last_month])
                    ->orderBy('date', 'ASC')
                    ->get();
            } elseif ($data['filter'] == 'thisMonth') {
                $get = Statistical::whereBetween('date', [$first_day_this_month, $now])
                    ->orderBy('date', 'ASC')
                    ->get();
            } elseif ($data['filter'] == 'lastYear') {
                $sql = Statistical::whereBetween('date', [$last_year, $now])
                    ->orderBy('date', 'ASC')
                    ->get();
                return response()->json(['rs' => $sql]);
            }

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->date,
                    'order' => $val->total_order,
                    'sales' => $val->sales,
                    'profit' => $val->profit,
                    'qty' => $val->qty,
                );
            }

            $data = json_encode($chart_data);
            return $data;
        }
    }

    function load_chart(Request $request)
    {
        if ($request->ajax()) {
            $thirty_day = now()->subDays(30)->format('d/m/Y');
            $now = now()->format('d/m/Y');
            $get = Statistical::whereBetween('date', [$thirty_day, $now])
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
            // $data = $chart_data;
            $data = json_encode($chart_data);
            return $data;
        }
    }
}
