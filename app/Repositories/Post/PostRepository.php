<?php

namespace App\Repositories\Post;

use App\Repositories\BaseRepository;
use App\Constants\Constants;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Post::class;
    }

    public function get_post_by_id($id)
    {
        $post = $this->model->select('id', 'title', 'desc', 'content', 'thumbnail')
            ->firstWhere('id', $id);
        return $post;
    }

    public function get_list_posts_trash($key = "", $paginate = 10, $orderBy = 'deleted_at')
    {
        $post = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'posts.user_id')
            ->leftjoin('category_posts', 'category_posts.id', '=', 'posts.user_id')
            ->select('posts.id', 'posts.title', 'posts.status', 'm_users.fullname', 'category_posts.name', 'posts.deleted_at')
            ->where('posts.deleted_at', '<>', Constants::EMPTY)
            ->where('posts.title', 'LIKE', "%{$key}%")
            ->orderByDesc("posts.{$orderBy}")
            ->paginate($paginate);
        return $post;
    }

    public function get_list_posts_status($status, $key = "", $paginate = 10, $orderBy = 'id')
    {
        $page = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'posts.user_id')
            ->leftjoin('category_posts', 'category_posts.id', '=', 'posts.user_id')
            ->select('posts.id', 'posts.title', 'posts.status', 'm_users.fullname', 'category_posts.name', 'posts.created_at')
            ->where('posts.status', "{$status}")
            ->where('posts.deleted_at', '=', Constants::EMPTY)
            ->where('posts.title', 'LIKE', "%{$key}%")
            ->orderByDesc("posts.{$orderBy}")
            ->paginate($paginate);
        return $page;
    }

    public function get_num_post_active()
    {
        $num = $this->model
            ->where('status', Constants::PUBLIC)
            ->where('deleted_at', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_post_trash()
    {
        $num = $this->model->where('deleted_at', '<>', Constants::EMPTY)->count();
        return $num;
    }

    public function get_num_post_pending()
    {
        $num = $this->model->where('status', Constants::PENDING)->where('deleted_at', Constants::EMPTY)->count();
        return $num;
    }
}
