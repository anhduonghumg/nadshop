<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class ExportSaleDate implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $from_date;
    protected $to_date;
    public function __construct($from_date, $to_date)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function view(): View
    {
        $format_from_date = Carbon::createFromFormat('d/m/Y', $this->from_date)->format('Y-m-d');
        $format_to_date = Carbon::createFromFormat('d/m/Y', $this->to_date)->format('Y-m-d');
        $sale = Order::selectRaw("SUM(product_orders.order_profit) as profit,SUM(product_orders.order_sales) as sale,SUM(product_orders.order_qty) as product_qty,COUNT(product_orders.id) as order_qty,product_orders.order_date")
            ->where('product_orders.order_status', '=', 'success')
            ->whereBetween('product_orders.order_date', [$format_from_date, $format_to_date])
            ->groupBy('product_orders.order_date')
            ->orderBy('product_orders.order_date', 'ASC')
            ->get();
        return view('client.excel.date', ['sale' => $sale]);
    }
}
