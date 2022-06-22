<?php

namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    // public function get_list_orders($paginate);
    public function get_info_order($id);
    public function get_num_order();
    public function count_order($data, $value);
    public function get_list_order();
    public function check_code($code);
    public function check_order($code);
    public function get_order($code);
    // public function get_action_by_status($status);
    // public function get_product_order($id);
}
