<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
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
        $list_act = ['delete' => 'Xóa tạm thời'];
        if ($status == 'trash') {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $pages = Page::onlyTrashed()->paginate(10);
        } elseif ($status == 'active') {
            $list_act = ['delete' => 'Xóa tạm thời'];
            $pages = Page::where('status', 'public')->paginate(10);
        } elseif ($status == 'pending') {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa tạm thời'];
            $pages = Page::where('status', 'pending')->paginate(10);
        } else {
            $kw = '';
            if ($request->has('kw')) {
                $kw = $request->input('kw');
            }
            $pages = Page::where('name', 'like', "%{$kw}%")->paginate(10);
        }

        $count_page_active = Page::where('status', 'public')->count();
        $count_page_trash = Page::onlyTrashed()->count();
        $count_page_pending = Page::Where('status', 'pending')->count();
        $count = [$count_page_active, $count_page_trash, $count_page_pending];
        return view('admin.page.list', compact('pages', 'count', 'list_act'));
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
                    'name' => 'required|string|max:255|unique:pages',
                    'desc' => 'required',
                    'content' => 'required',
                ],
                [
                    'required' => ':attribute không được để trống.',
                    'max' => ':attribute không được để trống có độ dài ít nhất :max kí tự.',
                    'unique' => ':attribute đã tồn tại.',
                ],
                [
                    'name' => 'Tên trang',
                    'desc' => 'Mô tả ngắn',
                    'content' => 'Nôi dung trang',
                ]
            );

            Page::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'desc' => $request->input('desc'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'user_id' => Auth::id()
            ]);

            return redirect('admin/page/list')->with('status', 'Đã thêm trang thành công');
        }
    }

    public function edit($id)
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
                        'desc' => ['required', 'string'],
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
                        'content' => 'Nội dung trang',
                        'desc' => 'Mô tả trang'
                    ]
                );

                Page::where('id', $id)->update(
                    [
                        'name' => $request->input('name'),
                        'content' => $request->input('content'),
                        'slug' => Str::slug($request->input('name')),
                        'desc' => $request->input('desc')
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
        if ($request->has('btn_action')) {
            $list_check = $request->input('list_check');
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    Page::destroy($list_check);
                    return redirect('admin/page/list')->with('status', 'Bạn đã xóa thành công.');
                } elseif ($act == 'restore') {
                    Page::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/page/list')->with('status', 'Bạn đã khôi phục thành công.');
                } elseif ($act == 'active') {
                    Page::whereIn('id', $list_check)->update(['status' => 'public']);
                    return redirect('admin/page/list')->with('status', 'Bạn đã kích hoạt trang thành công.');
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
