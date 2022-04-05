<?php

namespace App\Repositories\Brand;

use App\Repositories\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{
    public function get_brand_by_id($id, $select);
    public function get_list_brands_trash($paginate, $orderBy);
    public function get_list_brands_status($status, $paginate, $orderBy);
    public function get_num_brand_trash();
    public function get_num_brand_active();
    public function get_num_brand_pending();
}
