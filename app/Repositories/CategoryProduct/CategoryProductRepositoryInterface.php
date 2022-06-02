<?php

namespace App\Repositories\CategoryProduct;

use App\Repositories\RepositoryInterface;

interface CategoryProductRepositoryInterface extends RepositoryInterface
{

    public function get_cat_product_by_id($id, $select);
    public function get_list_cat_product_trash($paginate, $orderBy);
    public function get_list_cat_product_status($status, $paginate, $orderBy);
    public function get_num_cat_product_trash();
    public function get_num_cat_product_active();
    public function get_num_cat_product_pending();
    public function get_cat_menu($category);
    // public function check_parent_cat($id);
    // public function get_name_parent_cat($id);
}
