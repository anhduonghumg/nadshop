<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Statistical;
use App\Models\OrderDetail;
use App\Constants\Constants;
use Carbon\Carbon;

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
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            if ($from_date == null || $to_date == null) {
                return response()->json(['errors' => 'Vui lòng chọn ngày']);
            }

            if ($from_date > $to_date) {
                return response()->json(['errors' => 'Ngày bắt đầu không được lớn hơn ngày kết thúc']);
            }

            $format_from_date = Carbon::createFromFormat('d/m/Y', $from_date)->format('Y-m-d');
            $format_to_date = Carbon::createFromFormat('d/m/Y', $to_date)->format('Y-m-d');
            $get = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_total) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,product_orders.order_date")
                ->where('product_orders.order_status', '=', 'success')
                ->whereBetween('product_orders.order_date', [$format_from_date, $format_to_date])
                ->groupBy('product_orders.order_date')
                ->orderBy('product_orders.order_date', 'ASC')
                ->get();

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'sale' => $val->sale,
                    'profit' => $val->profit,
                    'product_qty' => $val->product_qty,
                    'order_qty' => $val->order_qty,
                );
            }
            $data = json_encode($chart_data);
            return $data;
        }
    }

    function filter(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $first_day_this_month = now()->startOfMonth()->format('Y-m-d');
            $early_last_month = now()->subMonth()->startOfMonth()->format('Y-m-d');
            $end_last_month = now()->subMonth()->endOfMonth()->format('Y-m-d');
            $last_week = now()->subDays(7)->format('Y-m-d');
            $last_year = now()->subDays(20)->format('Y-m-d');
            $now = now()->format('Y-m-d');
            if ($data['filter'] == 'lastWeek') {
                $get = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_total) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,product_orders.order_date")
                    ->where('product_orders.order_status', '=', 'success')
                    ->whereBetween('product_orders.order_date', [$last_week, $now])
                    ->groupBy('product_orders.order_date')
                    ->orderBy('product_orders.order_date', 'ASC')
                    ->get();
            } elseif ($data['filter'] == 'lastMonth') {
                $get = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_total) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,product_orders.order_date")
                    ->where('product_orders.order_status', '=', 'success')
                    ->whereBetween('product_orders.order_date', [$early_last_month, $end_last_month])
                    ->groupBy('product_orders.order_date')
                    ->orderBy('product_orders.order_date', 'ASC')
                    ->get();
            } elseif ($data['filter'] == 'thisMonth') {
                $get = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_total) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,product_orders.order_date")
                    ->where('product_orders.order_status', '=', 'success')
                    ->whereBetween('product_orders.order_date', [$first_day_this_month, $now])
                    ->groupBy('product_orders.order_date')
                    ->orderBy('product_orders.order_date', 'ASC')
                    ->get();
            } elseif ($data['filter'] == 'lastYear') {
                $get = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_total) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,product_orders.order_date")
                    ->where('product_orders.order_status', '=', 'success')
                    ->whereBetween('product_orders.order_date', [$last_year, $now])
                    ->groupBy('product_orders.order_date')
                    ->orderBy('product_orders.order_date', 'ASC')
                    ->get();
            } else {
                $get = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_total) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,product_orders.order_date")
                    ->where('product_orders.order_status', '=', 'success')
                    ->where('product_orders.order_date', $now)
                    ->orderBy('product_orders.order_date', 'ASC')
                    ->groupBy('product_orders.order_date')
                    ->get();
            }

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'sale' => $val->sale,
                    'profit' => $val->profit,
                    'product_qty' => $val->product_qty,
                    'order_qty' => $val->order_qty,
                );
            }

            $data = json_encode($chart_data);
            return $data;
        }
    }

    function load_chart(Request $request)
    {
        if ($request->ajax()) {
            $thirty_day = now()->subDays(7)->format('Y-m-d');
            $now = now()->format('Y-m-d');
            $get = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_total) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,product_orders.order_date")
                ->where('product_orders.order_status', '=', 'success')
                ->whereBetween('product_orders.order_date', [$thirty_day, $now])
                ->groupBy('product_orders.order_date')
                ->orderBy('product_orders.order_date', 'ASC')
                ->get();

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'sale' => $val->sale,
                    'profit' => $val->profit,
                    'product_qty' => $val->product_qty,
                    'order_qty' => $val->order_qty,
                );
            }

            $data = json_encode($chart_data);
            return $data;
        }
    }
}
