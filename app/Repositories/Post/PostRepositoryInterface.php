<?php

namespace App\Repositories\Post;

use App\Repositories\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{

    public function get_post_by_id($id);
    public function get_list_posts_trash($key, $paginate, $orderBy);
    public function get_list_posts_status($status, $key, $paginate, $orderBy);
    public function get_num_post_trash();
    public function get_num_post_active();
    public function get_num_post_pending();
}
