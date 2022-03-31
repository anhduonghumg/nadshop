<?php

namespace App\Http\Controllers;

use App\Models\M_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Constants\Constants;
use Illuminate\Support\Arr;

class AdminUserController extends Controller
{
    public function list(Request $request)
    {
        $status = $request->input('status');

        $list_act = ['delete' => 'Xóa tạm thời'];
        if ($status == Constants::TRASH) {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            // $users = M_user::get_list_users_trash();
            // dd($users);
            $users = M_user::get_list_users_trash();

            // dd($users);
            // ->paginate(20);
        } else {
            $kw = "";
            if ($request->has('keyword')) {
                $kw = $request->input('keyword');
            }
            $users = M_user::get_list_users($kw);
        }

        $count_user_active = M_user::count();
        $count_user_trash = M_user::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];
        return view('admin.user.list', compact('users', 'count', 'list_act'));
    }

    public function add()
    {
        return view('admin.user.add');
    }

    public function store(Request $request)
    {
        if ($request->has('btn_add')) {

            $request->validate(
                [
                    'fullname' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:m_users',
                    'username' => 'required|string|min:5|max:50|unique:m_users',
                    'phone' => 'required|numeric',
                    'password' => 'required|string|min:8|confirmed',
                ],
            );

            $data = [
                'fullname' => $request->input('fullname'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'phone' => $request->input('phone'),
                'username' => $request->input('username')
            ];

            M_user::add_user($data);

            return redirect()->route('admin.user.list')->with('status', trans('notification.add_success'));
        }
    }

    public function edit(Request $request, $id)
    {
        $id = $request->id;
        $user = M_user::select('id', 'fullname', 'username', 'email', 'phone', 'password', 'role_id')
            ->where("id", "{$id}")
            ->first();
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has('btn_update')) {

            $request->validate(
                [
                    'fullname' => 'required|string|max:255',
                    'phone' => 'required|numeric'
                ],
            );

            M_user::where('id', $id)->update([
                'fullname' => $request->input('fullname'),
                'phone' => $request->input('phone')
            ]);

            return redirect()->route('admin.user.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if (Auth::id() != $id) {
            $user = M_user::find($id);
            $user->delete();
            return redirect()->route('admin.user.list')->with('status',  trans('notification.delete'));
        } else {
            return redirect()->route('admin.user.list')->with('status', trans('notification.delete_yourself'));
        }
    }

    public function forceDelete($id)
    {
        $id = (int)$id;
        $user = M_user::find($id);
        $user->forceDelete();
        return redirect()->route('admin.user.list')->with('status', trans('notification.forceDelete'));
    }

    public function action(Request $request)
    {
        $list_check = collect($request->input('list_check'));
        if ($list_check->isNotEmpty()) {
            $list_check->each(function ($value, $key) use ($list_check) {
                if ($list_check->contains(Auth::id())) {
                    $list_check->forget($key);
                }
            });

            $act = $request->input('act');
            if ($act == Constants::DELETE) {
                M_user::destroy($list_check);
                return redirect()->route('admin.user.list')->with('status', trans('notification.delete_success'));
            } elseif ($act == Constants::RESTORE) {
                M_user::withTrashed()->whereIn('id', $list_check)->restore();
                return redirect()->route('admin.user.list')->with('status', trans('notification.restore_success'));
            } elseif ($act == Constants::FORCE_DELETE) {
                M_user::whereIn('id', $list_check)->forceDelete();
                return redirect()->route('admin.user.list')->with('status', trans('notification.force_delete_success'));
            } else {
                return redirect()->route('admin.user.list')->with('status', trans('notification.not_action'));
            }
        } else {
            return redirect()->route('admin.user.list')->with('status', trans('notification.not_element'));
        }
    }

    public function profile()
    {
        $id = Auth::id();
        $user = M_user::find($id);
        return view('admin.user.profile', compact('user'));
    }
    public function profileUpdate(Request $request, $id)
    {
        if (Auth::id() == $id) {
            $request->validate(
                [
                    'fullname' => 'required|string|max:255',
                    'phone' => 'required|numeric',
                ],
            );

            M_user::where('id', $id)->update([
                'fullname' => $request->input('fullname'),
                'phone' => $request->input('phone'),
            ]);

            return redirect()->route('admin.user.list')->with('status', trans('notification.update_success'));
        } else {
            return redirect('dashboard');
        }
    }

    public function changePass(Request $request)
    {
        $id = Auth::id();
        $user = M_user::find($id);
        return view('admin.user.changePass', compact('user'));
    }

    public function changePassUpdate(Request $request, $id)
    {
        if (Auth::id() == $id) {
            $request->validate(
                [
                    'password' => 'required|string|min:8|confirmed|',
                ],
            );
            $current_pass = Auth::user();
            if (Hash::check($request->password, $current_pass->password)) {
                return redirect()->back()->with('status', trans('notification.change_pass_fail'));
            } else {
                M_user::where('id', $id)->update([
                    'password' => Hash::make($request->input('password')),
                ]);
                return redirect()->route('admin.user.list')->with('status', trans('notification.change_pass_success'));
            }
        } else {
            return redirect('dashboard');
        }
    }
}
