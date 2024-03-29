<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use App\Constants\Constants;
use App\Models\Color;
use App\Models\Size;

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

    public function get_list_product($column, $take)
    {
        $result = $this->model
            ->select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price', 'product_details.product_discount')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->where("products.{$column}", Constants::TRUE)
            ->where('products.product_status', Constants::PUBLIC)
            ->where('products.deleted_at', '=', Constants::EMPTY)
            ->orderByDesc('products.id')
            ->distinct()
            ->take($take)
            ->get();
        return $result;
    }

    public function get_product_by_cat($id)
    {
        $result = $this->model
            ->select('products.id', 'products.product_name', 'products.product_thumb', 'product_details.product_price', 'category_products.category_product_name', 'product_details.product_discount')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->join('category_products', 'products.product_cat_id', '=', 'category_products.id')
            ->where('category_products.id', $id)
            ->distinct()
            ->get();
        return $result;
    }

    public function get_color_by_product($id)
    {
        $result = $this->model
            ->select('colors.id', 'colors.color_name', 'colors.code_color', 'products.id as proId')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->join('colors', 'product_details.color_id', '=', 'colors.id')
            ->where('product_details.product_id', $id)
            ->distinct()
            ->get();
        return $result;
    }
    public function get_size_by_product($color, $product)
    {
        $result = $this->model
            ->select('sizes.size_name', 'product_details.id', 'product_details.product_qty_stock', 'product_details.id as proId', 'products.id as pId')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->join('sizes', 'product_details.size_id', '=', 'sizes.id')
            ->where('product_details.product_id', $product)
            ->where('product_details.color_id', $color)
            ->get();
        return $result;
    }

    public function get_variant($id, $kw)
    {
        $result = $this->model
            ->select('product_details.*')
            ->leftjoin('product_details', 'products.id', '=', 'product_details.product_id')
            ->where('product_details.product_id', $id)
            ->where('product_detail_name', 'LIKE', "%{$kw}%")
            ->orderByDesc('product_details.color_id')
            ->paginate(20);
        // ->withPath("http://localhost/nadshop/admin/product/variant?id=" . $id);
        return $result;
    }

    public function get_product_by_filter($filter)
    {
        $product = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'products.user_id')
            ->leftjoin('brands', 'brands.id', '=', 'products.brand_id')
            ->leftJoin('category_products', 'category_products.id', '=', 'products.product_cat_id')
            ->select('products.id', 'products.product_name', 'products.product_status', 'products.product_thumb', 'm_users.fullname', 'category_products.category_product_name', 'products.created_at')
            ->where('products.product_status', Constants::PUBLIC)
            ->where('products.deleted_at', '=', Constants::EMPTY)
            ->where("products.{$filter}", 1)
            ->orderByDesc("products.views")
            ->paginate(20);
        return $product;
    }
    public function get_product_view()
    {
        $product = $this->model
            ->leftjoin('m_users', 'm_users.id', '=', 'products.user_id')
            ->leftjoin('brands', 'brands.id', '=', 'products.brand_id')
            ->leftJoin('category_products', 'category_products.id', '=', 'products.product_cat_id')
            ->select('products.id', 'products.product_name', 'products.product_status', 'products.product_thumb', 'm_users.fullname', 'category_products.category_product_name', 'products.created_at')
            ->where('products.product_status', Constants::PUBLIC)
            ->where('products.deleted_at', '=', Constants::EMPTY)
            ->orderByDesc("products.views")
            ->paginate(20);
        return $product;
    }
}
