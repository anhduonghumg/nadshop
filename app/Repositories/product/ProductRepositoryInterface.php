<?php

namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function get_product_by_id($id, $select);
    public function get_list_products_trash($key, $paginate, $orderBy);
    public function get_list_products_status($status, $key, $paginate, $orderBy);
    public function get_num_product_trash();
    public function get_num_product_active();
    public function get_num_product_pending();
    public function get_list_product($column, $take);
    public function get_product_by_cat($id);
    public function get_color_by_product($id);
}
