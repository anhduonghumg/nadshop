<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Constants\Constants;
use App\Models\CategoryProduct;
use App\Helpers\Recursive;
use App\Helpers\Category;
use App\Repositories\CategoryProduct\CategoryProductRepositoryInterface;

class AdminCategoryProductController extends Controller
{
    use Recursive;
    protected $cproductRepo;

    public function __construct(CategoryProductRepositoryInterface $cproductRepo)
    {
        $this->cproductRepo = $cproductRepo;
    }

    public function add(Request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'category_product_name' => 'required|max:100|unique:category_products'
                ]
            );
            $data = [
                'category_product_name' => $request->input('category_product_name'),
                'slug' => Str::slug($request->input('category_product_name')),
                'category_product_status' => $request->input('status'),
                'parent_id' => $request->input('parent_id'),
                'user_id' => Auth::id(),
                "created_at" => now(),
                "updated_at" => now(),
            ];

            $this->cproductRepo->add($data);
            return back()->with('status', trans('notification.add_success'));
        }
    }

    public function list(Request $request)
    {
        $status = $request->input('status');
        if (!$status || $status == Constants::ACTIVE) {
            $list_act = ['delete' => 'Xóa'];
            $category_product = $this->cproductRepo->get_list_cat_product_status(Constants::PUBLIC, $paginate = 10, $orderBy = "id");
        } elseif ($status == Constants::TRASH) {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $category_product = $this->cproductRepo->get_list_cat_product_trash($paginate = 10, $orderBy = 'deleted_at');
        } elseif ($status == Constants::PENDING) {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $category_product = $this->cproductRepo->get_list_cat_product_status(Constants::PENDING, $paginate = 10, $orderBy = "id");
        }

        $num_productCat_active = $this->cproductRepo->get_num_cat_product_active();
        $num_productCat_pending = $this->cproductRepo->get_num_cat_product_pending();
        $num_productCat_trash = $this->cproductRepo->get_num_cat_product_trash();
        $count = [$num_productCat_active, $num_productCat_pending, $num_productCat_trash];
        $data_cat_product = $this->dataSelect(new CategoryProduct, 'category_product_status', 'category_product_name');
        return view('admin.catProduct.list', compact('list_act', 'category_product', 'count', 'data_cat_product'));
    }

    public function edit($id)
    {
        if ($id != null) {
            $catProduct = $this->cproductRepo->get_cat_product_by_id($id, ['id', 'category_product_name', 'parent_id']);
            $data_cat_product = $this->dataSelect(new CategoryProduct, 'category_product_status', 'category_product_name');
            return view('admin.catProduct.edit', compact('catProduct', 'data_cat_product'));
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->has('btn_update')) {
            $request->validate(
                [
                    'category_product_name' => 'required|max:100|unique:category_products,category_product_name,' . $id . ',id'
                ]
            );

            $data = [
                'category_product_name' => $request->category_product_name,
                'slug' => Str::slug($request->category_product_name),
                'parent_id' => $request->parent_id,
                "updated_at" => now(),
            ];

            $this->cproductRepo->update($data, $id);
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            $data = ['deleted_at' => now()];
            $this->cproductRepo->delete($data, $id);
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.delete_success'));
        } else {
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.no_data'));
        }
    }

    public function forceDelete($id)
    {
        if ($id != null) {
            $this->cproductRepo->forceDelete($id);
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.force_delete_success'));
        } else {
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.no_data'));
        }
    }

    public function action(Request $request)
    {
        if ($request->has('btn_action')) {
            $list_check = $request->input('list_check');
            if ($list_check != null) {
                $act = $request->input('act');
                if ($act == Constants::DELETE) {
                    $data = ['deleted_at' => now()];
                    $this->cproductRepo->update($data, $list_check);
                    return redirect()->route('admin.catProduct.list')->with('status', trans('notification.delete_success'));
                } elseif ($act == Constants::ACTIVE) {
                    $data = ['category_product_status' => Constants::PUBLIC];
                    $this->cproductRepo->update($data, $list_check);
                    return redirect()->route('admin.catProduct.list')->with('status',  trans('notification.active_success'));
                } elseif ($act == Constants::RESTORE) {
                    $data = ['deleted_at' => Constants::EMPTY];
                    $this->cproductRepo->update($data, $list_check);
                    return redirect()->route('admin.catProduct.list')->with('status', trans('notification.restore_success'));
                } elseif ($act == Constants::FORCE_DELETE) {
                    $this->cproductRepo->forceDelete($list_check);
                    return redirect()->route('admin.catProduct.list')->with('status', trans('notification.force_delete_success'));
                } else {
                    return redirect()->route('admin.catProduct.list')->with('status', trans('notification.not_action'));
                }
            } else {
                return redirect()->route('admin.catProduct.list')->with('status', trans('notification.not_element'));
            }
        }
    }
}
