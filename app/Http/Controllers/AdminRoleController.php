<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Constants\Constants;

class AdminRoleController extends Controller
{
    protected $role;
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            return view('admin.role.add')->render();
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'role_name' => 'bail|required|max:255|unique:roles',
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
            return view('admin.role.listajax', compact('list_roles'))->render();
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
                return response()->json(['success' => trans('notification.add_success')]);
            } else {
                return response()->json(['errors' => trans('notification.no_data')]);
            }
        }
    }
}
