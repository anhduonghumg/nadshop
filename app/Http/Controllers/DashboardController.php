<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Statistical;
use App\Models\OrderDetail;
use App\Constants\Constants;

class DashboardController extends Controller
{
    function index()
    {
        $order_success = Order::where('order_status', Constants::SUCCESS)->count();
        $order_pending = Order::where('order_status', Constants::PENDING)->count();
        $order_cancel = Order::where('order_status', Constants::CANCEL)->count();
        $renvenue = array();
        $total = Order::select('order_total')->where('order_status', Constants::SUCCESS)->get();
        foreach ($total as $price) {
            $renvenue[] = $price->order_total;
        }
        $sale = array_sum($renvenue);
        return view('admin.dashboard', compact('order_success', 'order_pending', 'order_cancel', 'sale'));
    }

    function filter_by_date(Request $request)
    {
        if ($request->ajax()) {
            $chart_data = array();
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
            $first_day_this_month = now()->startOfMonth()->format('Y/m/d');
            $early_last_month = now()->subMonth()->startOfMonth()->format('Y/m/d');
            $end_last_month = now()->subMonth()->endOfMonth()->format('Y/m/d');
            $last_week = now()->subDays(7)->format('Y/m/d');
            $last_year = now()->subDays(20)->format('Y/m/d');
            $now = now()->format('Y/m/d');
            if ($data['filter'] == 'lastWeek') {
                $get = OrderDetail::selectRaw("SUM(product_orders.order_qty) as total_qty,SUM(product_orders.order_total) as total_price,product_orders.order_date")
                    ->join('product_orders', 'product_orders.id', 'product_order_details.product_order_id')
                    ->join('product_details', 'product_details.id', 'product_order_details.product_detail_id')
                    ->where('product_orders.order_status', '=', 'success')
                    ->whereBetween('product_orders.order_date', [$last_week, $now])
                    ->orderBy('product_orders.order_date', 'ASC')
                    ->get();
                // Statistical::whereBetween('date', [$last_week, $now])
                //     ->orderBy('date', 'ASC')
                //     ->get();
                // return response()->json(['rs' => $now]);
            } elseif ($data['filter'] == 'lastMonth') {
                $get = OrderDetail::selectRaw("SUM(product_orders.order_qty) as total_qty,SUM(product_orders.order_total) as total_price,product_orders.order_date")
                    ->join('product_orders', 'product_orders.id', 'product_order_details.product_order_id')
                    ->join('product_details', 'product_details.id', 'product_order_details.product_detail_id')
                    ->where('product_orders.order_status', 'success')
                    ->whereBetween('product_orders.order_date', [$early_last_month, $end_last_month])
                    ->orderBy('product_orders.order_date', 'ASC')
                    ->get();
                // $get = Statistical::whereBetween('date', [$early_last_month, $end_last_month])
                //     ->orderBy('date', 'ASC')
                //     ->get();
            } elseif ($data['filter'] == 'thisMonth') {
                $get = OrderDetail::selectRaw("SUM(product_orders.order_qty) as total_qty,SUM(product_orders.order_total) as total_price,product_orders.order_date")
                    ->join('product_orders', 'product_orders.id', 'product_order_details.product_order_id')
                    ->join('product_details', 'product_details.id', 'product_order_details.product_detail_id')
                    ->where('product_orders.order_status', 'success')
                    ->whereBetween('product_orders.order_date', [$first_day_this_month, $now])
                    ->orderBy('product_orders.order_date', 'ASC')
                    ->get();
                // $get = Statistical::whereBetween('date', [$first_day_this_month, $now])
                //     ->orderBy('date', 'ASC')
                //     ->get();
            } elseif ($data['filter'] == 'lastYear') {
                $get = OrderDetail::selectRaw("SUM(product_orders.order_qty) as total_qty,SUM(product_orders.order_total) as total_price,product_orders.order_date")
                    ->join('product_orders', 'product_orders.id', 'product_order_details.product_order_id')
                    ->join('product_details', 'product_details.id', 'product_order_details.product_detail_id')
                    ->where('product_orders.order_status', 'success')
                    ->whereBetween('product_orders.order_date', [$last_year, $now])
                    ->orderBy('product_orders.order_date', 'ASC')
                    ->get();
                // $sql = Statistical::whereBetween('date', [$last_year, $now])
                //     ->orderBy('date', 'ASC')
                //     ->get();
                // return response()->json(['rs' => $sql]);
            }

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'order' => $val->total_qty,
                    'sales' => $val->total_price,
                    // 'profit' => $val->profit,
                    // 'qty' => $val->qty,
                );
            }

            $data = json_encode($chart_data);
            return $data;
        }
    }

    function load_chart(Request $request)
    {
        if ($request->ajax()) {
            $thirty_day = now()->subDays(30)->format('Y/m/d');
            $now = now()->format('Y/m/d');
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
