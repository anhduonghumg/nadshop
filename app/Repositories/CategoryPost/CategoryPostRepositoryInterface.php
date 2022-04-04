<?php

namespace App\Repositories\CategoryPost;

use App\Repositories\RepositoryInterface;

interface CategoryPostRepositoryInterface extends RepositoryInterface
{
    public function get_cat_post_by_id($id, $select);
    public function get_list_cat_post_trash($paginate, $orderBy);
    public function get_list_cat_post_status($status, $paginate, $orderBy);
    public function get_num_cat_post_trash();
    public function get_num_cat_post_active();
    public function get_num_cat_post_pending();
    public function check_parent_cat($id);
    public function get_name_parent_cat($id);
}
