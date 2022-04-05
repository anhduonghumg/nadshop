<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{

    public function get_user_by_id($id, $select);
    public function get_list_users_trash($key, $paginate, $orderBy);
    public function get_list_users_status($key, $paginate, $orderBy);
    public function get_num_user_trash();
    public function get_num_user_active();
    public function get_num_user_pending();
}
