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

    public function get_user_by_id($id)
    {
        $user = $this->model
            ->select('m_users.id', 'm_users.fullname', 'm_users.username', 'm_users.phone', 'm_users.email', 'm_users.password', 'm_users.created_at', 'role_id')
            ->leftjoin('role_users', 'm_users.id', '=', 'role_users.user_id')
            ->leftjoin('roles', 'roles.id', '=', 'role_users.role_id')
            ->firstWhere('m_users.id', $id);
        return $user;
    }

    public function get_list_users_trash($key = "", $paginate = 10, $orderBy = 'id')
    {
        $user = $this->model
            ->select('m_users.id', 'm_users.fullname', 'm_users.email', 'm_users.created_at', 'm_users.deleted_at', 'role_name')
            ->leftjoin('role_users', 'm_users.id', '=', 'role_users.user_id')
            ->leftjoin('roles', 'roles.id', '=', 'role_users.role_id')
            ->whereNotNull('m_users.deleted_at')
            // ->where('m_users.id', '<>', Auth::id())
            ->where('m_users.fullname', 'LIKE', "%{$key}%")
            ->orderByDesc("m_users.{$orderBy}")
            ->paginate($paginate);
        return $user;
    }

    public function get_list_users_status($key = "", $paginate = 10, $orderBy = 'id')
    {
        $user = $this->model
            ->select('m_users.id', 'm_users.fullname', 'm_users.email', 'm_users.created_at', 'role_name')
            ->leftjoin('role_users', 'm_users.id', '=', 'role_users.user_id')
            ->leftjoin('roles', 'roles.id', '=', 'role_users.role_id')
            ->whereNull('m_users.deleted_at')
            // ->where('m_users.id', '<>', Auth::id())
            ->where('m_users.fullname', 'LIKE', "%{$key}%")
            ->orderByDesc("m_users.{$orderBy}")
            ->paginate($paginate);
        return $user;
    }

    public function get_num_user_active()
    {
        $num = $this->model
            ->whereNull('deleted_at')
            ->count();
        return $num;
    }

    public function get_num_user_trash()
    {
        $num = $this->model
            ->whereNotNull('deleted_at')
            ->count();
        return $num;
    }

    // public function get_num_user_pending()
    // {
    //     $num = $this->model->where('deleted_at', Constants::EMPTY)->count();
    //     return $num;
    // }
}
