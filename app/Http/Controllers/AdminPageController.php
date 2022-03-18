<?php

namespace App\Http\Controllers;

use App\Models\Page\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Page\StorePageRequest;

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
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $pages = Page::onlyTrashed()->paginate(10);
        } elseif ($status == 'pending') {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $pages = Page::where('status', 'pending')->paginate(10);
        } else {
            $key = "";
            $list_act = ['delete' => 'Xóa'];
            if ($request->input('keyword')) {
                $key = $request->input('keyword');
            }
            $pages = Page::list_page($key)->Paginate(10);
        }

        $num_page_active = Page::count();
        $num_page_trash = Page::onlyTrashed()->count();
        $num_page_pending = Page::where('status', 'pending')->count();
        $count = [$num_page_active, $num_page_trash, $num_page_pending];

        return view('admin.page.list', compact('pages', 'count', 'list_act'));
    }

    public function add()
    {
        return view('admin.page.add');
    }

    // Validation form request
    public function store(StorePageRequest $request)
    {
        if ($request->has('btn_add')) {
            $request->validated();
            $data = [
                'page_name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'desc' => $request->input('desc'),
                'status' => $request->input(('status')),
                'content' => $request->input('content'),
                'user_id' => Auth::id(),
            ];

            Page::add_page($data);
            return redirect()->route('admin.page.list')->with('status', trans('notification.add_success'));
        }
    }
    // public function store(Request $request)
    // {
    //     if ($request->has('btn_add')) {

    //         // Validation logic
    //         // $request->validate(
    //         //     [
    //         //         'name' => ['required', 'string', 'max:255', 'unique:pages'],
    //         //         'desc' => ['required', 'string'],
    //         //         'content' => ['required', 'string'],

    //         //     ],
    //         // );

    //         // Validation thủ công
    //         $validator = Validator::make($request->all(), [
    //             'name' => ['required', 'string', 'max:255', 'unique:pages'],
    //             'desc' => ['required', 'string'],
    //             'content' => ['required', 'string'],
    //         ]);

    //         if ($validator->fails()) {
    //             return back()->withErrors($validator);
    //         }

    //         $data = [
    //             'name' => $request->input('name'),
    //             'slug' => Str::slug($request->input('name')),
    //             'desc' => $request->input('desc'),
    //             'status' => $request->input(('status')),
    //             'content' => $request->input('content'),
    //             'user_id' => Auth::id(),
    //         ];

    //         Page::add_page($data);
    //         return redirect('admin/page/list')->with('status', 'Đã thêm trang thành công.');
    //     }
    // }

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
                        'name' => ['required', 'string', 'max:255', 'unique:pages,name,' . $id . ',id'],
                        'desc' => ['required', 'string'],
                        'content' => ['required', 'string']
                    ],
                );

                $data = [
                    'page_name' => $request->input('name'),
                    'content' => $request->input('content'),
                    'desc' => $request->input('desc'),
                    'slug' => Str::slug($request->input('name'))
                ];

                Page::update_page($data, $id);
                return redirect()->route('admin.page.list')->with('status', trans('notification.update_success'));
            }
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            Page::delete_page($id);
            return redirect()->route('admin.page.list')->with('status', trans('notification.delete_success'));
        } else {
            return redirect()->route('admin.page.list')->with('status', trans('notification.no_data'));
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
                    return redirect()->route('admin.page.list')->with('status', trans('notification.delete_success'));
                } elseif ($act == 'active') {
                    Page::whereIn('id', $list_check)->update(['status' => 'public']);
                    return redirect()->route('admin.page.list')->with('status', trans('notification.active_success'));
                } elseif ($act == 'restore') {
                    Page::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect()->route('admin.page.list')->with('status', trans('notification.restore_success'));
                } elseif ($act == 'forceDelete') {
                    Page::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect()->route('admin.page.list')->with('status', trans('notification.force_delete_success'));
                } else {
                    return redirect()->route('admin.page.list')->with('status', trans('notification.not_action'));
                }
            } else {
                return redirect()->route('admin.page.list')->with('status', trans('notification.not_element'));
            }
        }
    }
}
