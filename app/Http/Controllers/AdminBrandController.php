<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Constants\Constants;
use App\Models\Brand;
use App\Repositories\Brand\BrandRepositoryInterface;

class AdminBrandController extends Controller
{
    protected $brandRepo;
    public function __construct(BrandRepositoryInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    public function list(Request $request)
    {
        $status = $request->input('status');
        if (!$status || $status == Constants::ACTIVE) {
            $list_act = ['delete' => 'Xóa'];
            $list_brands = $this->brandRepo->get_list_brands_status(Constants::PUBLIC, $paginate = 10, $orderBy = "id");
        } elseif ($status == Constants::PENDING) {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $list_brands = $this->brandRepo->get_list_brands_status(Constants::PENDING, $paginate = 10, $orderBy = "id");
        } elseif ($status == Constants::TRASH) {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $list_brands = $this->brandRepo->get_list_brands_trash($paginate = 10, $orderBy = 'deleted_at');
        }

        $num_brand_active = $this->brandRepo->get_num_brand_active();
        $num_brand_trash = $this->brandRepo->get_num_brand_trash();
        $num_brand_pending = $this->brandRepo->get_num_brand_pending();
        $count = [$num_brand_active, $num_brand_trash, $num_brand_pending];

        return view('admin.brand.list', compact('list_brands', 'count', 'list_act'));
    }

    public function add(Request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'brand_name' => 'required|max:100|unique:brands',
                ],
            );
            $data = [
                'brand_name' => $request->input('brand_name'),
                'slug' => Str::slug($request->input('brand_name')),
                'status' => $request->input('status'),
                'user_id' => Auth::id(),
                "created_at" =>  now(),
                "updated_at" => now(),
            ];

            $this->brandRepo->add($data);
            return back()->with('status', trans('notification.add_success'));
        }
    }

    public function edit($id)
    {
        if ($id != null) {
            $brand = $this->brandRepo->get_brand_by_id($id, ['id', 'brand_name']);
            return view('admin.brand.edit', compact('brand'));
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->has('btn_update')) {
            $request->validate(
                [
                    'brand_name' => 'required|max:100|unique:brands',
                ],
            );
            $data = [
                'brand_name' => $request->input('brand_name'),
                'slug' => Str::slug($request->input('brand_name')),
                "updated_at" => now(),
            ];

            $this->brandRepo->update($data, $id);
            return redirect()->route('admin.brand.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            $data = [
                'deleted_at' => now(),
            ];

            $this->brandRepo->update($data, $id);
            return redirect()->route('admin.brand.list')->with('status', trans('notification.delete_success'));
        }
    }

    public function forceDelete($id)
    {
        if ($id != null) {
            $this->brandRepo->forceDelete($id);
            return back()->with('status', trans('notification.force_delete_success'));
        } else {
            return back()->with('status', trans('notification.no_data'));
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
                    $this->brandRepo->update($data, $list_check);
                    return back()->with('status', trans('notification.delete_success'));
                } elseif ($act == Constants::ACTIVE) {
                    $data = ['status' => Constants::PUBLIC];
                    $this->brandRepo->update($data, $list_check);
                    return back()->with('status', trans('notification.active_success'));
                } elseif ($act == Constants::RESTORE) {
                    $data = ['deleted_at' => Constants::EMPTY];
                    $this->brandRepo->update($data, $list_check);
                    return back()->with('status', trans('notification.restore_success'));
                } elseif ($act == Constants::FORCE_DELETE) {
                    $this->brandRepo->forceDelete($list_check);
                    return back()->with('status', trans('notification.force_delete_success'));
                } else {
                    return back()->with('status', trans('notification.not_action'));
                }
            } else {
                return back()->with('status',  trans('notification.not_element'));
            }
        }
    }
}
