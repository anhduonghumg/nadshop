<?php

namespace App\Http\Controllers;

use App\Models\M_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Constants\Constants;
use App\Repositories\User\UserRepositoryInterface;

class AdminUserController extends Controller
{
    protected $userRepo;
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = ['delete' => 'Xóa tạm thời'];
        $kw = $request->has('keyword') ? $request->input('keyword') : "";
        if ($status == Constants::TRASH) {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $users = $this->userRepo->get_list_users_trash($kw, $paginate = 10, $orderBy = "deleted_at");
        } else {
            $users = $this->userRepo->get_list_users_status($kw, $paginate = 10, $orderBy = "id");
        }

        $count_user_active = $this->userRepo->get_num_user_active();
        $count_user_trash = $this->userRepo->get_num_user_trash();
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

            $this->userRepo->add($data);
            return redirect()->route('admin.user.list')->with('status', trans('notification.add_success'));
        }
    }

    public function edit(Request $request, $id)
    {
        $id = $request->id;
        $user = $this->userRepo->get_user_by_id($id, ['id', 'fullname', 'username', 'phone', 'email', 'role_id', 'password', 'created_at']);
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
            $data = [
                'fullname' => $request->input('fullname'),
                'phone' => $request->input('phone')
            ];

            $this->userRepo->update($data, $id);
            return redirect()->route('admin.user.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if (Auth::id() != $id) {
            $data = ['deleted_at' => now()];
            $this->userRepo->delete($data, $id);
            return redirect()->route('admin.user.list')->with('status',  trans('notification.delete_success'));
        } else {
            return redirect()->route('admin.user.list')->with('status', trans('notification.delete_yourself'));
        }
    }

    public function forceDelete($id)
    {
        if (Auth::id() != $id) {
            $this->userRepo->forceDelete($id);
            return redirect()->route('admin.user.list')->with('status', trans('notification.force_delete_success'));
        }
        return redirect()->route('admin.user.list')->with('status', trans('notification.delete_yourself'));
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check != null) {
            $act = $request->input('act');
            if ($act == Constants::DELETE) {
                $data = ['deleted_at' => now()];
                $this->userRepo->delete($data, $list_check);
                return redirect()->route('admin.user.list')->with('status', trans('notification.delete_success'));
            } elseif ($act == Constants::RESTORE) {
                $data = ['deleted_at' => Constants::EMPTY];
                $this->userRepo->update($data, $list_check);
                return redirect()->route('admin.user.list')->with('status', trans('notification.restore_success'));
            } elseif ($act == Constants::FORCE_DELETE) {
                $this->userRepo->forceDelete($list_check);
                return redirect()->route('admin.user.list')->with('status', trans('notification.force_delete_success'));
            } else {
                return redirect()->route('admin.user.list')->with('status', trans('notification.not_action'));
            }
        }
        return redirect()->route('admin.user.list')->with('status', trans('notification.not_element'));
    }

    public function profile()
    {
        $id = Auth::id();
        $user = $this->userRepo->get_user_by_id($id, ['id', 'fullname', 'username', 'email', 'phone', 'created_at']);
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

            $data = [
                'fullname' => $request->input('fullname'),
                'phone' => $request->input('phone'),
            ];
            $this->userRepo->update($data, $id);
            return redirect()->route('admin.user.list')->with('status', trans('notification.update_success'));
        }
        return redirect('dashboard');
    }

    public function changePass(Request $request)
    {
        $id = Auth::id();
        $user = $this->userRepo->get_user_by_id($id, ['id', 'password']);
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
                $data = [
                    'password' => Hash::make($request->input('password')),
                ];
                $this->userRepo->update($data, $id);
                return redirect()->route('admin.user.list')->with('status', trans('notification.change_pass_success'));
            }
        } else {
            return redirect('dashboard');
        }
    }
}
