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

    public function get_info_order($id)
    {
        $result = $this->model->findOrFail($id);
        return $result;
    }

    public function get_list_order()
    {
        $result =  $this->model->select('product_orders.*', 'product_order_details.product_order_id')
            ->join('product_order_details', 'product_orders.id', '=', 'product_order_details.product_order_id')
            ->orderByDesc("product_orders.id")
            ->distinct()
            ->get();
        return $result->toArray();
    }

    public function get_num_order()
    {
        $result = $this->model->select('order_status')
            ->get();
        return $result->toArray();
    }

    public function count_order($data, $value)
    {
        return $data->where('order_status', $value)->count();
    }
}
