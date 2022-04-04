<?php

namespace App\Repositories\Page;

use App\Repositories\RepositoryInterface;

interface PageRepositoryInterface extends RepositoryInterface
{

    public function get_page_by_id($id);
    public function get_list_pages_trash($key, $paginate, $orderBy);
    public function get_list_pages_status($status, $key, $paginate, $orderBy);
    public function get_num_page_trash();
    public function get_num_page_active();
    public function get_num_page_pending();
}
