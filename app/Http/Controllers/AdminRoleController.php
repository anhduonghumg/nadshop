<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Permission;
use App\Constants\Constants;
use App\Models\RolePermiss;

class AdminRoleController extends Controller
{
    protected $role;
    protected $rolpermisse;
    protected $role_permiss;
    public function __construct(Role $role, Permission $permiss, RolePermiss $role_permiss)
    {
        $this->role = $role;
        $this->permiss = $permiss;
        $this->role_permiss = $role_permiss;
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            $list_permiss = $this->permiss->all();
            return view('admin.role.add', compact('list_permiss'))->render();
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'role_name' => 'bail|required|max:255|unique:roles',
                'role_permission' => 'required'
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $name = $request->role_name;

            $saveDataRole = [
                'role_name' => $name,
                'slug' => Str::slug($name),
                'created_at' => now(),
                'updated_at' => now()
            ];
            $saveRole = $this->role->create($saveDataRole);
            if ($saveRole) {
                $role_permission = $request->role_permission;
                foreach ($role_permission as $key => $value) {
                    $data = [
                        'role_id' => $saveRole->id,
                        'per_id' => $role_permission[$key]
                    ];
                    $this->role_permiss->create($data);
                }
                return response()->json(['success' => trans('notification.add_success')]);
            } else {
                return response()->json(['errors' => trans('notification.no_data')]);
            }
        }
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $list_roles = $this->role->all()->paginate(Constants::PAGINATE);
            $list_permissions = $this->permiss->all();
            return view('admin.role.listAjax', compact('list_roles', 'list_permissions'))->render();
        }
        return view('admin.role.role');
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->id;
            $role = $this->role->find($id);
            return view('admin.role.edit', compact('role'))->render();
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $id = (int)$request->data_id;
            $validator = Validator::make($request->all(), [
                'role_name' => 'bail|required|max:255|unique:roles,role_name,' . $id . ',id',
            ]);

            if ($validator->fails()) {
                $error = collect($validator->errors())->unique()->first();
                return response()->json(['errors' => $error]);
            }

            $name = $request->role_name;
            $saveDataRole = [
                'role_name' => $name,
                'slug' => Str::slug($name),
                'updated_at' => now()
            ];
            $saveRole = $this->role->where('id', $id)->update($saveDataRole);
            if ($saveRole) {
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
                $this->role_permiss->where('role_id', $id)->delete();
                $delete_role = $this->role->find($id)->delete();
                if ($delete_role)
                    return response()->json(['success' => trans('notification.force_delete_success')]);
                return response()->json(['errors' => trans('notification.no_data')]);
            }
            return response()->json(['errors' => trans('notification.no_data')]);
        }
    }
}
