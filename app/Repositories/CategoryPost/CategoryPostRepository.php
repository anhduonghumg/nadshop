<?php

namespace App\Repositories\CategoryPost;

use App\Repositories\BaseRepository;
use App\Constants\Constants;

class CategoryPostRepository extends BaseRepository implements CategoryPostRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\CategoryPost::class;
    }

    public function get_cat_post_by_id($id, $select = [])
    {

        $cat_post = $this->model
            ->select($select)
            ->firstWhere('id', $id);
        return $cat_post;
    }

    public function get_list_cat_post_trash($paginate = 10, $orderBy = 'deleted_at')
    {
        $cat_post = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'category_posts.user_id')
            ->select('category_posts.id', 'category_posts.name', 'category_posts.parent_id', 'category_posts.status', 'm_users.fullname', 'category_posts.created_at', 'category_posts.deleted_at')
            ->where('category_posts.deleted_at', '<>', Constants::EMPTY)
            ->orderByDesc($orderBy)
            ->paginate($paginate);
        return $cat_post;
    }

    public function get_list_cat_post_status($status, $paginate = 10, $orderBy = 'id')
    {
        $cat_post = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'category_posts.user_id')
            ->select('category_posts.id', 'category_posts.name', 'category_posts.parent_id', 'category_posts.status', 'm_users.fullname', 'category_posts.created_at')
            ->where('category_posts.status', "{$status}")
            ->where('category_posts.deleted_at', '=', Constants::EMPTY)
            ->orderByDesc($orderBy)
            ->paginate($paginate);
        return $cat_post;
    }

    public function get_num_cat_post_active()
    {
        $num = $this->model
            ->where('status', Constants::PUBLIC)
            ->where('deleted_at', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_cat_post_trash()
    {
        $num = $this->model
            ->where('deleted_at', '<>', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_cat_post_pending()
    {
        $num = $this->model
            ->where('status', Constants::PENDING)
            ->where('deleted_at', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function check_parent_cat($id)
    {
        $postCatAll = $this->model->select('parent_id')->get();
        $postCat = $this->model->select('id')->where('id', $id)->first();
        foreach ($postCatAll as $pc) {
            if ($postCat->id == $pc->parent_id)
                return true;
        }
        return false;
    }

    public function get_name_parent_cat($id)
    {
        $get_all = $this->model::all();
        if ($get_all->constains($id))
            return $this->model->select('name')->where('id', $id)->first();
        return null;
    }
}
