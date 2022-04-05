<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Constants\Constants;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\M_user::class;
    }

    public function get_user_by_id($id, $select = ['*'])
    {
        $user = $this->model->select($select)
            ->firstWhere('id', $id);
        return $user;
    }

    public function get_list_users_trash($key = "", $paginate = 10, $orderBy = 'id')
    {
        $user = $this->model
            // ->leftjoin('m_users', 'm_users.id', '=', 'posts.user_id')
            // ->leftjoin('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
            ->select('m_users.id', 'm_users.fullname', 'm_users.email', 'm_users.role_id', 'm_users.created_at', 'm_users.deleted_at')
            ->where('m_users.deleted_at', '<>', Constants::EMPTY)
            ->where('m_users.id', '<>', Auth::id())
            ->where('m_users.fullname', 'LIKE', "%{$key}%")
            ->orderByDesc("m_users.{$orderBy}")
            ->paginate($paginate);
        return $user;
    }

    public function get_list_users_status($key = "", $paginate = 10, $orderBy = 'id')
    {
        $user = $this->model
            // ->leftjoin('m_users', 'm_users.id', '=', 'posts.user_id')
            // ->leftjoin('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
            ->select('m_users.id', 'm_users.fullname', 'm_users.email', 'm_users.role_id', 'm_users.created_at')
            ->where('m_users.deleted_at', '=', Constants::EMPTY)
            ->where('m_users.id', '<>', Auth::id())
            ->where('m_users.fullname', 'LIKE', "%{$key}%")
            ->orderByDesc("m_users.{$orderBy}")
            ->paginate($paginate);
        return $user;
    }

    public function get_num_user_active()
    {
        $num = $this->model
            ->where('deleted_at', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_user_trash()
    {
        $num = $this->model
            ->where('deleted_at', '<>', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_user_pending()
    {
        $num = $this->model->where('deleted_at', Constants::EMPTY)->count();
        return $num;
    }
}
