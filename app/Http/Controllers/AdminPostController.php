<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Constants\Constants;
use App\Helpers\ImageUpload;
use App\Helpers\Recursive;
use App\Helpers\Number;


class AdminPostController extends Controller
{
    use ImageUpload, Recursive, Number;

    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {

        $status = $request->input('status');
        $key = isset($request->kw) ? $request->kw : "";
        if (!$status || $status == Constants::ACTIVE) {
            $list_act = ['delete' => 'Xóa'];
            $list_posts = DB::table('posts')
                ->join('M_users', 'M_users.id', '=', 'posts.user_id')
                ->join('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
                ->select('posts.*', 'M_users.fullname', 'category_posts.name')
                ->where("posts.status", "=", "public")
                ->where("posts.deleted_at", "=", Constants::EMPTY)
                ->where('posts.title', 'LIKE', "%{$key}%")
                ->orderBy('posts.created_at', 'desc')
                ->paginate(20);
        } else {
            if ($status == Constants::TRASH) {
                $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
                $list_posts = DB::table('posts')
                    ->join('M_users', 'M_users.id', '=', 'posts.user_id')
                    ->join('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
                    ->select('posts.*', 'M_users.fullname', 'category_posts.name')
                    ->where("posts.deleted_at", "<>", Constants::EMPTY)
                    ->where('posts.title', 'LIKE', "%{$key}%")
                    ->orderBy('posts.created_at', 'desc')
                    ->paginate(20);
            } elseif ($status == Constants::PENDING) {
                $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
                $list_posts = DB::table('posts')
                    ->join('M_users', 'M_users.id', '=', 'posts.user_id')
                    ->join('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
                    ->select('posts.*', 'M_users.fullname', 'category_posts.name')
                    ->where("posts.status", "=", "pending")
                    ->where("posts.deleted_at", "=", Constants::EMPTY)
                    ->where('posts.title', 'LIKE', "%{$key}%")
                    ->orderBy('posts.created_at', 'desc')
                    ->paginate(20);
            }
        }

        $num_post_active = DB::table('posts')->where('status', '=', Constants::PUBLIC)->where('deleted_at', '=', Constants::EMPTY)->count();
        $num_post_trash = DB::table('posts')->where('deleted_at', '<>', Constants::EMPTY)->count();
        $num_post_pending = DB::table('posts')->where('status', '=', Constants::PENDING)->where('deleted_at', '=', Constants::EMPTY)->count();
        $count = [$num_post_active, $num_post_trash, $num_post_pending];

        return view('admin.post.list', compact('list_posts', 'count', 'list_act'));
    }

    public function add()
    {
        $data_category_post = $this->dataSelect(new CategoryPost);
        return view('admin.post.add', compact('data_category_post'));
    }

    public function store(Request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'title' => ['required', 'string', 'max:255', 'unique:posts'],
                    'desc' => ['required', 'string'],
                    'content' => ['required', 'string'],
                    'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    'category_post' => ['required']
                ]
            );

            $data = [
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title')),
                'desc' => $request->input('desc'),
                'status' => $request->input(('status')),
                'content' => $request->input('content'),
                'user_id' => Auth::id(),
                'post_cat_id' => $request->input('category_post'),
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ];

            if ($request->hasFile('thumbnail')) {
                $dataImg = $this->ImageUpload($request->thumbnail, 'post');
                $data['thumbnail'] = $dataImg['file_path'];
            }

            DB::table('posts')->insert($data);
            return redirect('admin/post/list')->with('status', 'Đã thêm bài viết thành công.');
        }
    }

    public function edit(Request $request, $id)
    {
        $post = DB::table('posts')
            ->where('id', '=', $id)
            ->first();

        $data_cat_post = $this->dataSelect(new CategoryPost);
        return view('admin.post.edit', compact('post', 'data_cat_post'));
    }

    public function update(Request $request, $id)
    {
        if (!isset($id) || $id == 0) {
            return redirect('admin/post/list');
        } else {
            if ($request->has('btn_update')) {

                $request->validate(
                    [
                        'title' => ['required', 'string', 'max:255', 'unique:posts,title,' . $id . ',id'],
                        'desc' => ['required', 'string'],
                        'content' => ['required', 'string'],
                        'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                        'category_post' => ['required']
                    ],
                );

                $data = [
                    'title' => $request->input('title'),
                    'slug' => Str::slug($request->input('title')),
                    'desc' => $request->input('desc'),
                    'content' => $request->input('content'),
                    'post_cat_id' => $request->input('category_post'),
                    'updated_at' => \Carbon\Carbon::now(),
                ];

                if ($request->hasFile('thumbnail')) {
                    $dataImg = $this->ImageUpload($request->thumbnail, 'post');
                    $data['thumbnail'] = $dataImg['file_path'];
                }

                DB::table('posts')
                    ->where('id', $id)
                    ->update($data);

                return redirect('admin/post/list')->with('status', 'Bạn đã cập nhật bài viết thành công');
            }
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            $data = [
                'deleted_at' => \Carbon\Carbon::now()
            ];
            DB::table('posts')->where('id', $id)->update($data);
            return redirect('admin/post/list')->with('status', 'Xóa tạm thời bài viết thành công.');
        } else {
            return redirect('admin/post/list')->with('status', 'Không có dữ liệu.');
        }
    }

    public function forceDelete($id)
    {
        if ($id != null) {
            DB::table('posts')->where('id', $id)->delete();
            return redirect('admin/post/list')->with('status', 'Xóa vĩnh viễn bài viết thành công.');
        } else {
            return redirect('admin/post/list')->with('status', 'Không có dữ liệu.');
        }
    }

    public function action(Request $request)
    {
        if ($request->has('btn_action')) {
            $list_check = $request->input('list_check');
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == Constants::DELETE) {
                    DB::table('posts')->whereIn('id', $list_check)->update(['deleted_at' => \Carbon\Carbon::now()]);
                    return redirect('admin/post/list')->with('status', 'Bạn đã xóa thành công.');
                } elseif ($act == Constants::ACTIVE) {
                    DB::table('posts')->whereIn('id', $list_check)->update(['status' => Constants::PUBLIC]);
                    return redirect('admin/post/list')->with('status', 'Bạn đã kích hoạt thành công.');
                } elseif ($act == Constants::RESTORE) {
                    DB::table('posts')->whereIn('id', $list_check)->update(['deleted_at' => Constants::EMPTY]);
                    return redirect('admin/post/list')->with('status', 'Bạn đã khôi phục thành công.');
                } elseif ($act == Constants::FORCE_DELETE) {
                    DB::table('posts')->whereIn('id', $list_check)->delete();
                    return redirect('admin/post/list')->with('status', 'Bạn đã vĩnh viễn thành công.');
                } else {
                    return redirect('admin/post/list')->with('status', 'Bạn cần chọn tác vụ thực hiện.');
                }
            } else {
                return redirect('admin/post/list')->with('status', 'Bạn cần chọn phần tử để thực thi');
            }
        }
    }
}
