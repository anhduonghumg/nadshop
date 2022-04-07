<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use App\Constants\Constants;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Product::class;
    }

    public function get_product_by_id($id, $select = ['*'])
    {
        $product = $this->model->select($select)
            ->firstWhere('id', $id);
        return $product;
    }

    public function get_list_products_trash($key = "", $paginate = 10, $orderBy = 'deleted_at')
    {
        $product = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'products.user_id')
            ->leftjoin('brands', 'brands.id', '=', 'products.brand_id')
            ->leftJoin('category_products', 'category_products.id', '=', 'products.product_cat_id')
            ->select('products.id', 'products.product_name', 'products.product_status', 'products.product_thumb', 'm_users.fullname', 'category_products.category_product_name', 'products.created_at', 'products.deleted_at')
            ->where('products.deleted_at', '<>', Constants::EMPTY)
            ->where('products.product_name', 'LIKE', "%{$key}%")
            ->orderByDesc("products.{$orderBy}")
            ->paginate($paginate);
        return $product;
    }

    public function get_list_products_status($status, $key = "", $paginate = 10, $orderBy = 'id')
    {
        $product = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'products.user_id')
            ->leftjoin('brands', 'brands.id', '=', 'products.brand_id')
            ->leftJoin('category_products', 'category_products.id', '=', 'products.product_cat_id')
            ->select('products.id', 'products.product_name', 'products.product_status', 'products.product_thumb', 'm_users.fullname', 'category_products.category_product_name', 'products.created_at')
            ->where('products.product_status', "{$status}")
            ->where('products.deleted_at', '=', Constants::EMPTY)
            ->where('products.product_name', 'LIKE', "%{$key}%")
            ->orderByDesc("products.{$orderBy}")
            ->paginate($paginate);
        return $product;
    }

    public function get_num_product_active()
    {
        $num = $this->model
            ->where('product_status', Constants::PUBLIC)
            ->where('deleted_at', Constants::EMPTY)
            ->count();
        return $num;
    }

    public function get_num_product_trash()
    {
        $num = $this->model->where('deleted_at', '<>', Constants::EMPTY)->count();
        return $num;
    }

    public function get_num_product_pending()
    {
        $num = $this->model->where('product_status', Constants::PENDING)->where('deleted_at', Constants::EMPTY)->count();
        return $num;
    }
}
