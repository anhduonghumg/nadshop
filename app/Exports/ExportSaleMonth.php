<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class ExportSaleMonth implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $from_month;
    protected $to_month;
    public function __construct($from_month, $to_month)
    {
        $this->from_month = $from_month;
        $this->to_month = $to_month;
    }

    public function view(): View
    {
        $format_from_month = Carbon::createFromFormat('d/m/Y', $this->from_month)->startOfMonth()->format('Y-m-d');
        $format_to_month = Carbon::createFromFormat('d/m/Y', $this->to_month)->lastOfMonth()->format('Y-m-d');
        $sale = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_sales) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,MONTH(product_orders.order_date) as month_order")
            ->where('product_orders.order_status', '=', 'success')
            ->whereBetween('product_orders.order_date', [$format_from_month, $format_to_month])
            ->groupBy('month_order')
            ->orderBy('month_order', 'ASC')
            ->get();
        return view('client.excel.month', ['sale' => $sale]);
    }
}
