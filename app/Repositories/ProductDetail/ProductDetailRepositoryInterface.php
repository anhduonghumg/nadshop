<?php

namespace App\Repositories\ProductDetail;

use App\Repositories\RepositoryInterface;

interface ProductDetailRepositoryInterface extends RepositoryInterface
{
    // public function get_product_by_id($id, $select);
    // public function get_list_products_trash($key, $paginate, $orderBy);
    // public function get_list_products_status($status, $key, $paginate, $orderBy);
    // public function get_num_product_trash();
    // public function get_num_product_active();
    // public function get_num_product_pending();
    public function get_list_product_details($key, $orderBy, $paginate);
    public function get_product_detail_by_id($id, $select);
    public function show_product_detail($id);
}
