<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryPost\CategoryPostRepositoryInterface;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\Recursive;
use App\Constants\Constants;


class AdminCategoryPostController extends Controller
{
    use Recursive;
    protected CategoryPostRepositoryInterface $cpostRepo;

    public function __construct(CategoryPostRepositoryInterface $cpostRepo)
    {
        $this->cpostRepo = $cpostRepo;
    }

    public function add(Request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'name' => 'required|max:100|unique:category_posts',
                ],
            );

            $data = [
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'status' => $request->input('status'),
                'parent_id' => $request->input('parent_id'),
                'user_id' => Auth::id(),
                "created_at" => now(),
                "updated_at" => now(),
            ];

            $this->cpostRepo->add($data);
            return back()->with('status', trans('notification.add_success'));
        }
    }

    public function list(Request $request)
    {
        $status = $request->input('status');
        if ($status == Constants::TRASH) {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $category_post = $this->cpostRepo->get_list_cat_post_trash($paginate = 10, $orderBy = 'deleted_at');
        } elseif ($status == Constants::PENDING) {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $category_post = $this->cpostRepo->get_list_cat_post_status(Constants::PENDING, $paginate = 10, $orderBy = "id");
        } else {
            $list_act = ['delete' => 'Xóa'];
            $category_post = $this->cpostRepo->get_list_cat_post_status(Constants::PUBLIC, $paginate = 10, $orderBy = "id");
        }

        $num_postCat_active = $this->cpostRepo->get_num_cat_post_active();
        $num_postCat_trash = $this->cpostRepo->get_num_cat_post_trash();
        $num_postCat_pending = $this->cpostRepo->get_num_cat_post_pending();
        $count = [$num_postCat_active, $num_postCat_trash, $num_postCat_pending];
        $data_cat_post = $this->dataSelect(new CategoryPost);

        return view('admin.catPost.list', compact('category_post', 'data_cat_post', 'count', 'list_act'));
    }


    public function edit($id)
    {
        $catPost = $this->cpostRepo->get_cat_post_by_id($id, ['id', 'name']);
        $data_cat_post = $this->dataSelect(new CategoryPost);
        return view('admin.catPost.edit', compact('catPost', 'data_cat_post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|max:100|unique:category_posts,name,' . $id . ',id',
            ],
        );

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            "updated_at" => \Carbon\Carbon::now(),
        ];

        $this->cpostRepo->update($data, $id);
        return redirect()->route('admin.catPost.list')->with('status', trans('notification.update_success'));
    }

    public function delete($id)
    {
        if ($id != null) {
            $catPost = $this->cpostRepo->get_cat_post_by_id($id, ['status']);
            if ($catPost->status == Constants::PENDING) {
                $data = ['deleted_at' => now()];
                $this->cpostRepo->update($data, $id);
            } elseif ($this->cpostRepo->check_parent_cat($id)) {
                return  redirect()->route('admin.catPost.list')->with('status', trans('notification.delete_cat_child'));
            } else {
                $data = ['deleted_at' => now()];
                $this->cpostRepo->update($data, $id);
            }
            return redirect()->route('admin.catPost.list')->with('status', trans('notification.delete_success'));
        } else {
            return redirect()->route('admin.catPost.list')->with('status', trans('notification.no_data'));
        }
    }

    public function forceDelete($id)
    {
        if ($id != null) {
            $this->cpostRepo->forceDelete($id);
            return redirect()->route('admin.catPost.list')->with('status', trans('notification.force_delete_success'));
        } else {
            return redirect()->route('admin.catPost.list')->with('status', trans('notification.no_data'));
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
                    $this->cpostRepo->update($data, $list_check);
                    return redirect()->route('admin.catPost.list')->with('status', trans('notification.delete_success'));
                } elseif ($act == Constants::ACTIVE) {
                    $data = ['status' => Constants::PUBLIC];
                    $this->cpostRepo->update($data, $list_check);
                    return redirect()->route('admin.catPost.list')->with('status',  trans('notification.active_success'));
                } elseif ($act == Constants::RESTORE) {
                    $data = ['deleted_at' => Constants::EMPTY];
                    $this->cpostRepo->update($data, $list_check);
                    return redirect()->route('admin.catPost.list')->with('status', trans('notification.restore_success'));
                } elseif ($act == Constants::FORCE_DELETE) {
                    $this->cpostRepo->forceDelete($list_check);
                    return redirect()->route('admin.catPost.list')->with('status', trans('notification.force_delete_success'));
                } else {
                    return redirect()->route('admin.catPost.list')->with('status', trans('notification.not_action'));
                }
            } else {
                return redirect()->route('admin.catPost.list')->with('status', trans('notification.not_element'));
            }
        }
    }
}
