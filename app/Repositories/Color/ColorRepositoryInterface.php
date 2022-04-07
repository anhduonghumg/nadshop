<?php

namespace App\Repositories\Color;

use App\Repositories\RepositoryInterface;

interface ColorRepositoryInterface extends RepositoryInterface
{
    public function get_color_by_id($id, $select);
    public function get_list_color($paginate = 10, $orderBy = "id");
}
