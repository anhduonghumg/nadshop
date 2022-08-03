<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class ExportSaleYear implements FromView
{
    protected $from_year;
    protected $to_year;
    public function __construct($from_year, $to_year)
    {
        $this->from_year = $from_year;
        $this->to_year = $to_year;
    }

    public function view(): View
    {
        $sale = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_sales) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,YEAR(product_orders.order_date) as year_order")
            ->where('product_orders.order_status', '=', 'success')
            ->whereRaw("product_orders.order_status = 'success' and YEAR(product_orders.order_date) BETWEEN '{$this->from_year}' and '{$this->to_year}'")
            ->groupBy('year_order')
            ->orderBy('year_order', 'ASC')
            ->get();
        return view('client.excel.year', ['sale' => $sale]);
    }
}
