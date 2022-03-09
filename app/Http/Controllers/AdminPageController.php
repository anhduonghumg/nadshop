<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $status = $request->input('status');

        if ($status == 'trash') {
            $list_action = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $list_pages = Page::onlyTrashed()->paginate(5);
        } else {
            $key = "";
            $list_action = ['delete' => 'Xóa'];
            if ($request->input('keyword')) {
                $key = $request->input('keyword');
            }
            $list_pages = Page::where("name", "LIKE", "%{$key}%")->simplePaginate(1);
        }

        $num_page_active = Page::count();
        $num_page_trash = Page::onlyTrashed()->count();

        return view('admin.page.list', compact('list_pages', 'num_page_active', 'num_page_trash', 'list_action'));
    }

    public function add()
    {
        return view('admin.page.add');
    }

    public function store(Request $request)
    {
        if ($request->has('btn_add')) {

            $request->validate(
                [
                    'name' => ['required', 'string', 'min:6', 'unique:pages'],
                    'content' => ['required', 'string'],
                ],
                [
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute có độ dài ít nhất :min ký tự',
                    'string' => ':attribute phải là một chuỗi',
                    'unique' => ':attribute đã tồn tại'
                ],
                [
                    'name' => 'Tiêu đề trang',
                    'content' => 'Nội dung trang',
                ]
            );
            Page::create(
                [
                    'name' => $request->input('name'),
                    'slug' => Str::slug($request->input('name')),
                    'content' => $request->input('content'),
                    'user_id' => Auth::id(),
                ]
            );
            return redirect('admin/page/list')->with('status', 'Đã thêm trang thành công.');
        }
    }

    public function edit(Request $request, $id)
    {
        if (!isset($id) || $id == 0) {
            return redirect('admin/page/list');
        } else {
            $page = Page::find($id);
        }
        return view('admin.page.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        if (!isset($id) || $id == 0) {
            return redirect('admin/user/list');
        } else {
            if ($request->has('btn_update')) {

                $request->validate(
                    [
                        'name' => ['required', 'string', 'min:6', 'unique:pages,name,' . $id . ',id'],
                        'content' => ['required', 'string']
                    ],
                    [
                        'required' => ':attribute không được để trống',
                        'min' => ':attribute có độ dài tối đa :min ký tự',
                        'string' => ':attribute phải là một chuỗi',
                        'unique' => ':attribute đã tồn tại'
                    ],
                    [
                        'name' => 'Tiêu đề trang',
                        'content' => 'Nội dung trang'
                    ]
                );

                Page::where('id', $id)->update(
                    [
                        'name' => $request->input('name'),
                        'content' => $request->input('content'),
                        'slug' => Str::slug($request->input('name'))
                    ]
                );

                return redirect('admin/page/list')->with('status', 'Đã cập nhập trang thành công.');
            }
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            $page = Page::find($id);
            $page->delete();
            return redirect('admin/page/list')->with('status', 'Xóa trang thành công.');
        } else {
            return redirect('admin/page/list')->with('status', 'Không có dữ liệu.');
        }
    }

    public function action(Request $request)
    {
        // Kiểm tra action có tồn tại hay ko
        if ($request->has('btn_action')) {
            // Lấy ra danh sách bản ghi được chọn
            $list_check = $request->input('list_check');
            // Kiểm tra list_check có rỗng ko
            if (!empty($list_check)) {
                // Lấy hành động
                $act = $request->input('act');
                if ($act == 'delete') {
                    Page::destroy($list_check);
                    return redirect('admin/page/list')->with('status', 'Bạn đã xóa thành công.');
                } elseif ($act == 'restore') {
                    Page::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/page/list')->with('status', 'Bạn đã khôi phục thành công.');
                } elseif ($act == 'forceDelete') {
                    Page::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect('admin/page/list')->with('status', 'Bạn đã vĩnh viễn thành công.');
                } else {
                    return redirect('admin/page/list')->with('status', 'Bạn cần chọn tác vụ thực hiện.');
                }
            } else {
                return redirect('admin/page/list')->with('status', 'Bạn cần chọn phần tử để thực thi');
            }
        }
    }
}
