<?php

namespace App\Repositories\Brand;

use App\Repositories\BaseRepository;
use App\Constants\Constants;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Brand::class;
    }

    public function get_brand_by_id($id, $select = [])
    {

        $brand = $this->model
            ->select($select)
            ->firstWhere('id', $id);
        return $brand;
    }

    public function get_list_brands_trash($paginate = 10, $orderBy = 'deleted_at')
    {
        $brand = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'brands.user_id')
            ->select('brands.id', 'brands.brand_name', 'brands.status', 'm_users.fullname', 'brands.created_at', 'brands.deleted_at')
            ->where('brands.deleted_at', '<>', Constants::EMPTY)
            ->orderByDesc($orderBy)
            ->paginate($paginate);
        return $brand;
    }

    public function get_list_brands_status($status, $paginate = 10, $orderBy = 'id')
    {
        $brand = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'brands.user_id')
            ->select('brands.id', 'brands.brand_name', 'brands.status', 'm_users.fullname', 'brands.created_at')
            ->where('brands.status', "{$status}")
            ->where('brands.deleted_at', '=', Constants::EMPTY)
            ->orderByDesc($orderBy)
            ->paginate($paginate);
        return $brand;
    }

    public function get_num_brand_active()
    {
        $num = $this->model
            ->where('status', Constants::PUBLIC)
            ->where('deleted_at', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_brand_trash()
    {
        $num = $this->model
            ->where('deleted_at', '<>', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_brand_pending()
    {
        $num = $this->model
            ->where('status', Constants::PENDING)
            ->where('deleted_at', Constants::EMPTY)
            ->count();
        return $num;
    }
}
