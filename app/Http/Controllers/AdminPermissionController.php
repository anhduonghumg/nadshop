<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Constants\Constants;

class AdminPermissionController extends Controller
{
    protected $permiss;
    public function __construct(Permission $permiss)
    {
        $this->permiss = $permiss;
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            return view('admin.permission.add')->render();
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'per_name' => 'bail|required|max:255|unique:permissions',
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $name = $request->per_name;
            $saveDataPermiss = [
                'per_name' => $name,
                'slug' => Str::slug($name),
                'created_at' => now(),
                'updated_at' => now()
            ];
            $savePermiss = $this->permiss->create($saveDataPermiss);
            if ($savePermiss) {
                return response()->json(['success' => trans('notification.add_success')]);
            } else {
                return response()->json(['errors' => trans('notification.no_data')]);
            }
        }
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $list_permissions = $this->permiss->all();
            return view('admin.permission.listajax', compact('list_permissions'))->render();
        }
        return view('admin.permission.list');
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $permission = $this->permiss->find($id);
            return view('admin.permission.edit', compact('permission'))->render();
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->data_id;
            $validator = Validator::make($request->all(), [
                'per_name' => 'bail|required|max:255|unique:permissions,per_name,' . $id . ',id',
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $name = $request->per_name;
            $savePermission = [
                'per_name' => $name,
                'slug' => Str::slug($name),
                'updated_at' => now()
            ];
            $savePermission = $this->permiss->find($id)->update($savePermission);
            if ($savePermission) {
                return response()->json(['success' => trans('notification.update_success')]);
            } else {
                return response()->json(['errors' => trans('notification.no_data')]);
            }
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            if ($id != null) {
                $delete_role = $this->permiss->find($id)->delete();
                if ($delete_role)
                    return response()->json(['success' => trans('notification.force_delete_success')]);
                return response()->json(['errors' => trans('notification.no_data')]);
            }
            return response()->json(['errors' => trans('notification.no_data')]);
        }
    }
}
