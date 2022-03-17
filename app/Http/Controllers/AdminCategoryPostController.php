<?php

namespace App\Http\Controllers;

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
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ];

            DB::table('category_posts')->insert($data);

            return back()->with('status', 'Bạn đã thêm danh mục thành công');
        }
    }

    public function list(Request $request)
    {
        $status = $request->input('status');
        $key = isset($request->kw) ? $request->kw : "";
        if (!$status || $status == Constants::ACTIVE) {
            $list_act = ['delete' => 'Xóa'];
            $category_post = DB::table('category_posts')
                ->join('M_users', 'M_users.id', '=', 'category_posts.user_id')
                ->select('category_posts.*', 'M_users.fullname')
                ->where("category_posts.status", "=", Constants::PUBLIC)
                ->where("category_posts.deleted_at", "=", Constants::EMPTY)
                ->where('category_posts.name', 'LIKE', "%{$key}%")
                ->orderBy('category_posts.created_at', 'desc')
                ->paginate(20);
        } else {
            if ($status == Constants::TRASH) {
                $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
                $category_post = DB::table('category_posts')
                    ->join('M_users', 'M_users.id', '=', 'category_posts.user_id')
                    ->select('category_posts.*', 'M_users.fullname')
                    ->where("category_posts.deleted_at", "<>", Constants::EMPTY)
                    ->where('category_posts.name', 'LIKE', "%{$key}%")
                    ->orderBy('category_posts.created_at', 'desc')
                    ->paginate(20);
            } elseif ($status == Constants::PENDING) {
                $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
                $category_post = DB::table('category_posts')
                    ->join('M_users', 'M_users.id', '=', 'category_posts.user_id')
                    ->select('category_posts.*', 'M_users.fullname')
                    ->where("category_posts.status", "=", Constants::PENDING)
                    ->where("category_posts.deleted_at", "=", Constants::EMPTY)
                    ->where('category_posts.name', 'LIKE', "%{$key}%")
                    ->orderBy('category_posts.created_at', 'desc')
                    ->paginate(20);
            }
        }


        $num_postCat_active = DB::table('category_posts')->where('status', '=', Constants::PUBLIC)->where('deleted_at', '=', Constants::EMPTY)->count();
        $num_postCat_trash = DB::table('category_posts')->where('deleted_at', '<>', Constants::EMPTY)->count();
        $num_postCat_pending = DB::table('category_posts')->where('status', '=', Constants::PENDING)->where('deleted_at', '=', Constants::EMPTY)->count();
        $count = [$num_postCat_active, $num_postCat_trash, $num_postCat_pending];
        $data_cat_post = $this->dataSelect(new CategoryPost);

        return view('admin.catPost.list', compact('category_post', 'data_cat_post', 'count', 'list_act'));
    }


    public function edit($id)
    {
        $catPost = DB::table('category_posts')->where('id', $id)->first();
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

        DB::table('category_posts')->where('id', $id)->update($data);
        return redirect()->route('admin.catPost.list')->with('status', 'Bạn đã cập nhật danh mục thành công');
    }

    public function delete($id)
    {
        if ($id != null) {
            $catPost = DB::table('category_posts')->where('id', $id)->first();
            if ($catPost->status == Constants::PENDING) {
                DB::table('category_posts')->where('id', $id)->update(['deleted_at' => \Carbon\Carbon::now()]);
            } elseif (CategoryPost::check_parent_post_cat($id)) {
                return redirect('admin/post/cat/list')->with('status', 'Bạn phải xóa danh mục con trước.');
            } else {
                DB::table('category_posts')->where('id', $id)->update(['deleted_at' => \Carbon\Carbon::now()]);
            }
            return redirect('admin/post/cat/list')->with('status', 'Xóa danh mục thành công.');
        } else {
            return redirect('admin/post/cat/list')->with('status', 'Không có dữ liệu.');
        }
    }

    public function forceDelete($id)
    {
        if ($id != null) {
            DB::table('category_posts')->where('id', $id)->delete();
            return redirect('admin/post/cat/list')->with('status', 'Xóa vĩnh viễn bài viết thành công.');
        } else {
            return redirect('admin/post/cat/list')->with('status', 'Không có dữ liệu.');
        }
    }

    public function action(Request $request)
    {
        if ($request->has('btn_action')) {
            $list_check = $request->input('list_check');
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == Constants::DELETE) {
                    DB::table('category_posts')->whereIn('id', $list_check)->update(['deleted_at' => \Carbon\Carbon::now()]);
                    return redirect('admin/post/cat/list')->with('status', 'Bạn đã xóa thành công.');
                } elseif ($act == Constants::ACTIVE) {
                    DB::table('category_posts')->whereIn('id', $list_check)->update(['status' => Constants::PUBLIC]);
                    return redirect('admin/post/cat/list')->with('status', 'Bạn đã kích hoạt thành công.');
                } elseif ($act == Constants::RESTORE) {
                    DB::table('category_posts')->whereIn('id', $list_check)->update(['deleted_at' => Constants::EMPTY]);
                    return redirect('admin/post/cat/list')->with('status', 'Bạn đã khôi phục thành công.');
                } elseif ($act == Constants::FORCE_DELETE) {
                    DB::table('category_posts')->whereIn('id', $list_check)->delete();
                    return redirect('admin/post/cat/list')->with('status', 'Bạn đã vĩnh viễn thành công.');
                } else {
                    return redirect('admin/post/cat/list')->with('status', 'Bạn cần chọn tác vụ thực hiện.');
                }
            } else {
                return redirect('admin/post/cat/list')->with('status', 'Bạn cần chọn phần tử để thực thi');
            }
        }
    }
}
