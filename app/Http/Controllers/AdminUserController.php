<?php

namespace App\Http\Controllers;

use App\Models\M_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function list(Request $request)
    {
        $status = $request->input('status');

        $list_act = ['delete' => 'Xóa tạm thời'];
        if ($status == 'trash') {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $users = M_user::onlyTrashed()->paginate(5);
        } else {
            $kw = "";
            if ($request->has('keyword')) {
                $kw = $request->input('keyword');
            }
            $users = M_user::where('name', 'like', "%{$kw}%")->paginate(5);
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
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:m_users',
                    'username' => 'required|string|min:5|max:50|unique:m_users',
                    'phone' => 'required|numeric',
                    'password' => 'required|string|min:8|confirmed',

                ],
                [
                    'required' => ':attribute không được để trống.',
                    'min' => ':attribute không được để trống có độ dài ít nhất :min kí tự.',
                    'max' => ':attribute không được để trống có độ dài ít nhất :max kí tự.',
                    'confirmed' => 'Xác nhận mật khẩu không thành công.',
                    'unique' => ':attribute đã tồn tại.',
                    'numberic' => ':attribute phải là một chuỗi số.',
                    // 'size' => ':attribute phải là :size số.'
                ],
                [
                    'name' => 'Họ và tên',
                    'email' => 'Email',
                    'password' => 'Password',
                    'phone' => 'Số điện thoại',
                    'username' => 'Tên người dùng'
                ]
            );

            M_user::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'phone' => $request->input('phone'),
                'username' => $request->input('username')
            ]);

            return redirect('admin/user/list')->with('status', 'Đã thêm thành viên thành công');
        }
    }

    public function edit(Request $request, $id)
    {
        $user = M_user::find($id);

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has('btn_update')) {

            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'phone' => 'required|numeric'
                ],
                [
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được để trống có độ dài ít nhất :min kí tự',
                    'max' => ':attribute không được để trống có độ dài ít nhất :max kí tự',
                    'numeric' => ':attribute phải là một chuối số.',
                    // 'size' => ':attribute phải là :size số.'
                ],
                [
                    'name' => 'Tên người dùng',
                    'phone' => 'Số điện thoại'
                ]
            );

            M_user::where('id', $id)->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone')
            ]);

            return redirect('admin/user/list')->with('status', 'Đã cập nhập thành viên thành công.');
        }
    }

    public function delete($id)
    {
        if (Auth::id() != $id) {
            $user = M_user::find($id);
            $user->delete();

            return redirect('admin/user/list')->with('status', 'Bạn đã xóa thành viên thành công');
        } else {
            return redirect('admin/user/list')->with('status', 'Bạn không thể xóa chính mình');
        }
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            foreach ($list_check as $k => $id) {
                if (Auth::id() == $id) {
                    unset($list_check[$k]);
                }
            }

            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    M_user::destroy($list_check);
                    return redirect('admin/user/list')->with('status', 'Bạn đã xóa thành công.');
                } elseif ($act == 'restore') {
                    M_user::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/user/list')->with('status', 'Bạn đã khôi phục thành công.');
                } else {
                    return redirect('admin/user/list')->with('status', 'Bạn cần chọn hành động để thực hiện.');
                }
            }
            return redirect('admin/user/list')->with('status', 'Bạn không thể thao tác trên tài khoản của bạn.');
        } else {
            return redirect('admin/user/list')->with('status', 'Bạn cần chọn phần tử cần thực hiện.');
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
                    'name' => 'required|string|max:255',
                    'phone' => 'required|numeric',
                ],
                [
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được để trống có độ dài ít nhất :min kí tự',
                    'max' => ':attribute không được để trống có độ dài ít nhất :max kí tự',
                    'numeric' => ':attribute phải là một chuối số.',
                    // 'size' => ':attribute phải là :size số.'
                ],
                [
                    'name' => 'Tên người dùng',
                    'phone' => 'Số điện thoại'
                ]
            );

            M_user::where('id', $id)->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
            ]);

            return redirect('admin/user/list')->with('status', 'Bạn đã cập nhập thông tin thành công');
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
                [
                    'min' => ':attribute không được để trống có độ dài ít nhất :min kí tự.',
                    'confirmed' => 'Xác nhận mật khẩu không thành công.',
                ],
                [
                    'password' => 'Mật khẩu',
                ]

            );
            $current_pass = Auth::user();
            if (Hash::check($request->password, $current_pass->password)) {
                M_user::where('id', $id)->update([
                    'password' => Hash::make($request->input('password')),
                ]);
                return redirect('admin/user/list')->with('status', 'Bạn đã thay đổi password thành công');
            } else {
                return redirect()->back()->with('status', 'Bạn không nên để mật khẩu mới giống mật khẩu cũ');
            }
        } else {
            return redirect('dashboard');
        }
    }
}
