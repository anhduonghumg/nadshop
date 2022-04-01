<?php

namespace App\Http\Controllers;

use App\Models\Page\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Page\StorePageRequest;
use App\Constants\Constants;
use App\Repositories\Page\PageRepositoryInterface;

class AdminPageController extends Controller
{
    protected $pageRepo;

    public function __construct(PageRepositoryInterface $pageRepo)
    {
        $this->pageRepo = $pageRepo;
        // $this->middleware(function (Request $request, $next) {
        //     session(['module_active' => 'page']);
        //     return $next($request);
        // });
    }

    public function list(Request $request)
    {
        $status = $request->input('status');
        $key = "";
        if ($request->has('keyword')) {
            $key = $request->input('keyword');
        }

        if ($status == Constants::TRASH) {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $pages = Page::get_list_page_trash();
        } elseif ($status == Constants::PENDING) {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $pages = Page::get_list_page_by_status(Constants::PENDING, $key);
        } else {
            $list_act = ['delete' => 'Xóa'];
            $pages = Page::get_list_page_by_status(Constants::PUBLIC, $key);
        }

        $num_page_active = Page::where('status', Constants::PUBLIC)->where('deleted_at', Constants::EMPTY)->count();
        $num_page_trash = Page::where('deleted_at', '<>', Constants::EMPTY)->count();
        $num_page_pending = Page::where('status', 'pending')->where('deleted_at', Constants::EMPTY)->count();
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
                'page_name' => $request->input('page_name'),
                'slug' => Str::slug($request->input('page_name')),
                'desc' => $request->input('desc'),
                'status' => $request->input(('status')),
                'content' => $request->input('content'),
                'user_id' => Auth::id(),
            ];

            $this->pageRepo->add($data);
            return redirect()->route('admin.page.list')->with('status', trans('notification.add_success'));
        }
    }

    public function edit(Request $request, $id)
    {

        if ($request->has($id) || $id != 0) {
            $page = Page::get_page_by_id($id);
        } else {
            return redirect('admin/page/list');
        }
        return view('admin.page.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has($id)  || $id != 0) {
            if ($request->has('btn_update')) {
                $request->validate(
                    [
                        'page_name' => ['required', 'string', 'max:255', 'unique:pages,page_name,' . $id . ',id'],
                        'desc' => ['required', 'string'],
                        'content' => ['required', 'string']
                    ],
                );

                $data = [
                    'page_name' => $request->input('page_name'),
                    'content' => $request->input('content'),
                    'desc' => $request->input('desc'),
                    'slug' => Str::slug($request->input('page_name'))
                ];

                $this->pageRepo->update($data, $id);
                return redirect()->route('admin.page.list')->with('status', trans('notification.update_success'));
            }
        } else {
            return redirect()->route('admin.page.list');
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            $data = ['deleted_at' => now()];
            $this->pageRepo->delete($data, $id);
            return redirect()->route('admin.page.list')->with('status', trans('notification.delete_success'));
        } else {
            return redirect()->route('admin.page.list')->with('status', trans('notification.no_data'));
        }
    }

    public function forceDelete($id)
    {
        if ($id != null) {
            $this->pageRepo->forceDelete($id);
            return redirect()->route('admin.page.list')->with('status', trans('notification.force_delete_success'));
        } else {
            return redirect()->route('admin.page.list')->with('status', trans('notification.no_data'));
        }
    }

    public function action(Request $request)
    {
        if ($request->has('btn_action')) {
            $list_check = collect($request->input('list_check'));
            if ($list_check->isNotEmpty()) {
                $act = $request->input('act');
                if ($act == Constants::DELETE) {
                    $data = ['deleted_at' => now()];
                    $this->pageRepo->delete($data, $list_check);
                    return redirect()->route('admin.page.list')->with('status', trans('notification.delete_success'));
                } elseif ($act == Constants::ACTIVE) {
                    $data = ['status' => Constants::PUBLIC];
                    $this->pageRepo->update($data, $list_check);
                    return redirect()->route('admin.page.list')->with('status', trans('notification.active_success'));
                } elseif ($act == Constants::RESTORE) {
                    $data = ['deleted_at' => Constants::EMPTY];
                    $this->update_model(new Page, $data, $list_check);
                    return redirect()->route('admin.page.list')->with('status', trans('notification.restore_success'));
                } elseif ($act == Constants::FORCE_DELETE) {
                    $this->pageRepo->forceDelete($list_check);
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
