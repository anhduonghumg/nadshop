<?php

namespace App\Repositories\CategoryProduct;

use App\Repositories\BaseRepository;
use App\Constants\Constants;

class CategoryProductRepository extends BaseRepository implements CategoryProductRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\CategoryProduct::class;
    }

    public function get_cat_product_by_id($id, $select = [])
    {
        $cat_post = $this->model
            ->select($select)
            ->firstWhere('id', $id);
        return $cat_post;
    }

    public function get_list_cat_product_trash($paginate = 10, $orderBy = 'deleted_at')
    {
        $cat_post = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'category_products.user_id')
            ->select('category_products.id', 'category_products.category_product_name', 'category_products.parent_id', 'category_products.category_product_status', 'm_users.fullname', 'category_products.created_at', 'category_products.deleted_at')
            ->where('category_products.deleted_at', '<>', Constants::EMPTY)
            ->orderByDesc($orderBy)
            ->paginate($paginate);
        return $cat_post;
    }

    public function get_list_cat_product_status($status, $paginate = 10, $orderBy = 'id')
    {
        $cat_post = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'category_products.user_id')
            ->select('category_products.id', 'category_products.category_product_name', 'category_products.parent_id', 'category_products.category_product_status', 'm_users.fullname', 'category_products.created_at')
            ->where('category_products.category_product_status', "{$status}")
            ->where('category_products.deleted_at', '=', Constants::EMPTY)
            ->orderByDesc($orderBy)
            ->paginate($paginate);
        return $cat_post;
    }

    public function get_num_cat_product_active()
    {
        $num = $this->model
            ->where('category_product_status', Constants::PUBLIC)
            ->where('deleted_at', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_cat_product_trash()
    {
        $num = $this->model
            ->where('deleted_at', '<>', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_cat_product_pending()
    {
        $num = $this->model
            ->where('category_product_status', Constants::PENDING)
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

    public function get_name_parent_category($id)
    {
        $get_all = $this->model::all();
        if ($get_all->constains($id))
            return $this->model->select('category_product_name')->where('id', $id)->first();
        return null;
    }
}
