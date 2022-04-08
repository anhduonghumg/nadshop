<?php

namespace App\Repositories\Size;

use App\Repositories\RepositoryInterface;

interface SizeRepositoryInterface extends RepositoryInterface
{
    public function get_size_by_id($id, $select);
    public function get_list_size();
    public function get_list_size_product();
}
