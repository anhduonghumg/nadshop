<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Constants\Constants;
use App\Models\CategoryProduct;
use App\Helpers\Recursive;
use App\Helpers\Check;

class AdminCategoryProductController extends Controller
{
    use Recursive, Check;

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
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ];

            DB::table('category_products')->insert($data);
            return back()->with('status', trans('notification.add_success'));
        }
    }

    public function list(Request $request)
    {
        $status = $request->input('status');
        if (!$status || $status == Constants::ACTIVE) {
            $list_act = ['delete' => 'Xóa'];
            $category_product = DB::table('category_products')
                ->join('M_users', 'M_users.id', '=', 'category_products.user_id')
                ->select('category_products.*', 'm_users.fullname')
                ->where("category_products.category_product_status", "=", Constants::PUBLIC)
                ->where("category_products.deleted_at", '=', Constants::EMPTY)
                ->orderBy('category_products.created_at', 'desc')
                ->paginate(20);
        } elseif ($status == Constants::TRASH) {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $category_product = DB::table('category_products')
                ->join('m_users', 'm_users.id', '=', 'category_products.user_id')
                ->select('category_products.*', 'm_users.fullname')
                ->where("category_products.deleted_at", "<>", Constants::EMPTY)
                ->orderBy('category_products.created_at', 'desc')
                ->paginate(20);
        } elseif ($status == Constants::PENDING) {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $category_product = DB::table('category_products')
                ->join('m_users', 'm_users.id', '=', 'category_products.user_id')
                ->select('category_products.*', 'm_users.fullname')
                ->where("category_products.category_product_status", "=", Constants::PENDING)
                ->where("category_products.deleted_at", "=", Constants::EMPTY)
                ->orderBy('category_products.created_at', 'desc')
                ->paginate(20);
        }

        $num_productCat_active = DB::table('category_products')->where('category_product_status', '=', Constants::PUBLIC)->where('deleted_at', '=', Constants::EMPTY)->count();
        $num_productCat_trash = DB::table('category_products')->where('deleted_at', '<>', Constants::EMPTY)->count();
        $num_productCat_pending = DB::table('category_products')->where('category_product_status', '=', Constants::PENDING)->where('deleted_at', '=', Constants::EMPTY)->count();
        $count = [$num_productCat_active, $num_productCat_trash, $num_productCat_pending];
        $data_cat_product = $this->dataSelect(new CategoryProduct, 'category_product_status', 'category_product_name');
        return view('admin.catProduct.list', compact('list_act', 'category_product', 'count', 'data_cat_product'));
    }

    public function edit($id)
    {
        if ($id != null) {
            $catProduct = DB::table('category_products')->where('id', $id)->first();
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
                "updated_at" => \Carbon\Carbon::now(),
            ];

            DB::table('category_products')->where('id', $id)->update($data);
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            $catProduct = DB::table('category_products')->where('id', $id)->first();
            if ($catProduct->category_product_status == Constants::PENDING) {
                DB::table('category_posts')->where('id', $id)->update(['deleted_at' => \Carbon\Carbon::now()]);
            } elseif ($this->check_parent_cat('category_products', $id)) {
                return redirect()->route('admin.catProduct.list')->with('status', trans('notification.delete_cat_child'));
            } else {
                DB::table('category_products')->where('id', $id)->update(['deleted_at' => \Carbon\Carbon::now()]);
            }
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.delete_success'));
        } else {
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.no_data'));
        }
    }


    public function forceDelete($id)
    {
        if ($id != null) {
            DB::table('category_products')->where('id', $id)->delete();
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.force_delete_success'));
        } else {
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.no_data'));
        }
    }

    public function action(Request $request)
    {
        if ($request->has('btn_action')) {
            $list_check = $request->input('list_check');
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == Constants::DELETE) {
                    DB::table('category_products')->whereIn('id', $list_check)->update(['deleted_at' => \Carbon\Carbon::now()]);
                    return redirect()->route('admin.catProduct.list')->with('status', trans('notification.delete_success'));
                } elseif ($act == Constants::ACTIVE) {
                    DB::table('category_products')->whereIn('id', $list_check)->update(['category_product_status' => Constants::PUBLIC]);
                    return redirect()->route('admin.catProduct.list')->with('status', trans('notification.active_success'));
                } elseif ($act == Constants::RESTORE) {
                    DB::table('category_products')->whereIn('id', $list_check)->update(['deleted_at' => Constants::EMPTY]);
                    return redirect()->route('admin.catProduct.list')->with('status', trans('notification.restore_success'));
                } elseif ($act == Constants::FORCE_DELETE) {
                    DB::table('category_products')->whereIn('id', $list_check)->delete();
                    return redirect()->route('admin.catProduct.list')->with('status', trans('notification.force_delete_success'));
                }
            } else {
                return redirect()->route('admin.catProduct.list')->with('status', trans('notification.not_action'));
            }
        } else {
            return redirect()->route('admin.catProduct.list')->with('status', trans('notification.not_element'));
        }
    }
}
