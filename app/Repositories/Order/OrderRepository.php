<?php

namespace App\Repositories\Order;

use App\Repositories\BaseRepository;
use App\Constants\Constants;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Order::class;
    }

    public function get_list_orders($paginate)
    {
        $result = $this->model->select('product_orders.*', 'product_order_details.product_order_id')
            ->join('product_order_details', 'product_orders.id', '=', 'product_order_details.product_order_id')
            ->orderByDesc("product_orders.id")
            ->distinct()
            ->paginate($paginate);
        return $result;
    }
}
