<?php

namespace App\Repositories\Page;

use App\Repositories\BaseRepository;
use App\Constants\Constants;

class PageRepository extends BaseRepository implements PageRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Page\Page::class;
    }

    public function get_page_by_id($id)
    {
        $page = $this->model->select('id', 'page_name', 'desc', 'content')
            ->firstWhere('id', $id);
        return $page;
    }

    public function get_list_pages_trash($key = "", $paginate = 10, $orderBy = 'deleted_at')
    {
        $page = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'pages.user_id')
            ->select('pages.id', 'pages.page_name', 'pages.status', 'm_users.fullname', 'pages.deleted_at')
            ->where('pages.deleted_at', '<>', Constants::EMPTY)
            ->where('pages.page_name', 'LIKE', "%{$key}%")
            ->orderByDesc("pages.{$orderBy}")
            ->paginate($paginate);
        return $page;
    }

    public function get_list_pages_status($status, $key = "", $paginate = 10, $orderBy = 'id')
    {
        $page = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'pages.user_id')
            ->select('pages.id', 'pages.page_name', 'pages.status', 'm_users.fullname', 'pages.created_at')
            ->where('pages.status', "{$status}")
            ->where('pages.deleted_at', '=', Constants::EMPTY)
            ->where('pages.page_name', 'LIKE', "%{$key}%")
            ->orderByDesc("pages.{$orderBy}")
            ->paginate($paginate);
        return $page;
    }

    public function get_num_page_active()
    {
        $num = $this->model->where('status', Constants::PUBLIC)->where('deleted_at', Constants::EMPTY)->count();
        return $num;
    }

    public function get_num_page_trash()
    {
        $num = $this->model->where('deleted_at', '<>', Constants::EMPTY)->count();
        return $num;
    }

    public function get_num_page_pending()
    {
        $num = $this->model->where('status', Constants::PENDING)->where('deleted_at', Constants::EMPTY)->count();
        return $num;
    }
}
