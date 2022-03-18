<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Constants\Constants;
use App\Models\Brand;

class AdminBrandController extends Controller
{

    public function list(Request $request)
    {
        $status = $request->input('status');
        if (!$status || $status == Constants::ACTIVE) {
            $list_act = ['delete' => 'Xóa'];
            $list_brands = DB::table('brands')
                ->join('m_users', 'm_users.id', '=', 'brands.user_id')
                ->select('brands.*', 'm_users.fullname')
                ->where('brands.status', '=', Constants::PUBLIC)
                ->where('brands.deleted_at', '=', Constants::EMPTY)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } elseif ($status == Constants::PENDING) {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $list_brands = DB::table('brands')
                ->join('m_users', 'm_users.id', '=', 'brands.user_id')
                ->select('brands.*', 'm_users.fullname')
                ->where('brands.status', '=', Constants::PENDING)
                ->where('brands.deleted_at', '=', Constants::EMPTY)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } elseif ($status == Constants::TRASH) {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $list_brands = DB::table('brands')
                ->join('m_users', 'm_users.id', '=', 'brands.user_id')
                ->select('brands.*', 'm_users.fullname')
                ->where('brands.deleted_at', '<>', Constants::EMPTY)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        $num_brand_active = DB::table('brands')->where('status', '=', Constants::PUBLIC)->where('deleted_at', '=', Constants::EMPTY)->count();
        $num_brand_trash = DB::table('brands')->where('deleted_at', '<>', Constants::EMPTY)->count();
        $num_brand_pending = DB::table('brands')->where('status', '=', Constants::PENDING)->where('deleted_at', '=', Constants::EMPTY)->count();
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
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ];

            DB::table('brands')->insert($data);
            return back()->with('status', trans('notification.add_success'));
        }
    }

    public function edit($id)
    {
        if ($id != null) {
            $brand = DB::table('brands')->where('id', $id)->first();
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
                "updated_at" => \Carbon\Carbon::now(),
            ];

            DB::table('brands')->where('id', $id)->update($data);
            return redirect()->route('admin.brand.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            $data = [
                'deleted_at' => \Carbon\Carbon::now(),
            ];

            DB::table('brands')->where('id', $id)->update($data);
            return redirect()->route('admin.brand.list')->with('status', trans('notification.delete_success'));
        }
    }
    public function action(Request $request)
    {
        if ($request->has('btn_action')) {
            $list_check = $request->input('list_check');
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == Constants::DELETE) {
                    DB::table('brands')->whereIn('id', $list_check)->update(['deleted_at' => \Carbon\Carbon::now()]);
                    return back()->with('status', trans('notification.delete_success'));
                } elseif ($act == Constants::ACTIVE) {
                    DB::table('brands')->whereIn('id', $list_check)->update(['status' => Constants::PUBLIC]);
                    return back()->with('status', trans('notification.active_success'));
                } elseif ($act == Constants::RESTORE) {
                    DB::table('brands')->whereIn('id', $list_check)->update(['deleted_at' => Constants::EMPTY]);
                    return back()->with('status', trans('notification.restore_success'));
                } elseif ($act == Constants::FORCE_DELETE) {
                    DB::table('brands')->whereIn('id', $list_check)->delete();
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
