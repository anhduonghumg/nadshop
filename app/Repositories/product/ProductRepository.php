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
        // $post = $this->model
        //     ->leftjoin('m_users', 'm_users.id', '=', 'products.user_id')
        //     ->leftjoin('brands', 'brands.id', '=', 'products.brand_id')
        //     ->leftJoin('category_products', 'category_products.id', '=', 'products.product_cat_id')
        //     ->select('products.id', 'products.title', 'posts.status', 'posts.thumbnail', 'm_users.fullname', 'category_posts.name', 'posts.deleted_at')
        //     ->where('posts.deleted_at', '<>', Constants::EMPTY)
        //     ->where('posts.title', 'LIKE', "%{$key}%")
        //     ->orderByDesc("posts.{$orderBy}")
        //     ->paginate($paginate);
        // return $post;
    }

    public function get_list_products_status($status, $key = "", $paginate = 10, $orderBy = 'id')
    {
        // $post = $this->model
        //     ->leftjoin('m_users', 'm_users.id', '=', 'posts.user_id')
        //     ->leftjoin('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
        //     ->select('posts.id', 'posts.title', 'posts.status', 'posts.thumbnail', 'm_users.fullname', 'category_posts.name', 'posts.created_at')
        //     ->where('posts.status', "{$status}")
        //     ->where('posts.deleted_at', '=', Constants::EMPTY)
        //     ->where('posts.title', 'LIKE', "%{$key}%")
        //     ->orderByDesc("posts.{$orderBy}")
        //     ->paginate($paginate);
        // return $post;
    }

    public function get_num_product_active()
    {
        $num = $this->model
            ->where('status', Constants::PUBLIC)
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
        $num = $this->model->where('status', Constants::PENDING)->where('deleted_at', Constants::EMPTY)->count();
        return $num;
    }
}
