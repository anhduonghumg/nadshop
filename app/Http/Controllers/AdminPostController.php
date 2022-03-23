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

            // ========Query thuần túy==========
            #1: Đếm số lượng bản ghi của bảng posts có trạng thái là public với DB:raw
            // $list_posts = DB::table('posts', 'baiviet')
            //     ->select(DB::raw('count(*) as post,baiviet.status'))
            //     ->where('baiviet.status', '=', 'public')
            //     ->groupBy('baiviet.status')
            //     ->get();

            #2: Lấy tên danh mục,parent_id,lớn nhất với selectRaw
            // $list_posts = DB::table('category_posts', 'danhmuc')
            //     ->selectRaw('danhmuc.name as post_cat_name,max(parent_id) as max_id')
            //     ->join('posts', 'posts.post_cat_id', '=', 'category_posts.id')
            //     ->where('category_posts.status', '=', 'public')
            //     ->groupBy('category_posts.name')
            //     ->orderBy('category_posts.name')
            //     ->get();

            #3: Tính số ngày đã cập nhập bài viết với select Raw
            // $list_posts = DB::table('posts', 'baiviet')
            //     ->selectRaw('date(baiviet.updated_at) - date(baiviet.created_at) as num_day')
            //     ->get();

            #4: Nhóm ngày cập nhập với selectRawm,groupByRaw,havingRaw,orderByRa
            // $list_posts = DB::table('category_posts', 'baiviet')
            //     ->selectRaw("day(updated_at),count(id) as total_cat")
            //     ->groupByRaw("day(updated_at)")
            //     ->havingRaw("total_cat > 0")
            //     ->orderByRaw("day(updated_at) desc")
            //     ->get();

            #5: Lấy tất cả các trường của các bảng posts,category_posts,m_users với Select
            // $list_posts = DB::select("SELECT *
            // FROM posts
            //  JOIN category_posts on posts.post_cat_id = category_posts.id
            //  JOIN m_users on posts.user_id = m_users.id");

            // ========Query Builder==========
            #1: Lấy tất cả các trường của các bảng posts,category_posts,m_users với dk status = 'public'
            // sử dụng join
            // $list_posts = DB::table('posts', 'baiviet')
            //     ->join('M_users', 'M_users.id', '=', 'posts.user_id')
            //     ->join('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
            //     ->select('baiviet.*', 'M_users.fullname', 'category_posts.name')
            //     ->where("baiviet.status", "=", "public")
            //     ->where("baiviet.deleted_at", "=", Constants::EMPTY)
            //     ->where('baiviet.title', 'LIKE', "%{$key}%")
            //     ->orderBy('baiviet.created_at', 'desc')
            //     ->paginate(20);

            // sử dụng left join
            // $list_posts = DB::table('posts', 'baiviet')
            //     ->leftjoin('M_users', 'M_users.id', '=', 'posts.user_id')
            //     ->leftjoin('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
            //     ->select('baiviet.*', 'M_users.fullname', 'category_posts.name')
            //     ->where("baiviet.status", "=", "public")
            //     ->where("baiviet.deleted_at", "=", Constants::EMPTY)
            //     ->where('baiviet.title', 'LIKE', "%{$key}%")
            //     ->orderBy('baiviet.created_at', 'desc')
            //     ->paginate(20);

            // sử dụng right join
            // $list_posts = DB::table('posts','baiviet')
            // ->rightjoin('M_users', 'M_users.id', '=', 'posts.user_id')
            // ->rightjoin('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
            // ->select('baiviet.*', 'M_users.fullname', 'category_posts.name')
            // ->where("baiviet.status", "=", "public")
            // ->where("baiviet.deleted_at", "=", Constants::EMPTY)
            // ->where('baiviet.title', 'LIKE', "%{$key}%")
            // ->orderBy('baiviet.created_at', 'desc')
            // ->paginate(20);

            #2. Lấy tổng số bài viết của tác giả
            $list_posts = DB::table('posts')
                ->leftjoin('m_users', 'm_users.id', '=', 'posts.user_id')
                ->leftjoin('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
                ->select('m_users.fullname as author', DB::raw('count(*) as total_post'))
                ->groupBy('m_users.fullname')
                ->having('total_post', '>', 1)
                ->get();

            dd($list_posts);
            #3. Sử dụng whereor
            // $list_posts = 

            // dd($list_posts->toSql());
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
            return redirect()->route('admin.post.list')->with('status', trans('notification.add_success'));
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
            return redirect()->route('admin.post.list');
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

                return redirect()->route('admin.post.list')->with('status', trans('notification.update_success'));
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
            return redirect()->route('admin.post.list')->with('status', trans('notification.delete_success'));
        } else {
            return redirect()->route('admin.post.list')->with('status', trans('notification.no_data'));
        }
    }

    public function forceDelete($id)
    {
        if ($id != null) {
            DB::table('posts')->where('id', $id)->delete();
            return redirect()->route('admin.post.list')->with('status', trans('notification.force_delete_success'));
        } else {
            return redirect()->route('admin.post.list')->with('status', trans('notification.no_data'));
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
                    return redirect()->route('admin.post.list')->with('status', trans('notification.delete_success'));
                } elseif ($act == Constants::ACTIVE) {
                    DB::table('posts')->whereIn('id', $list_check)->update(['status' => Constants::PUBLIC]);
                    return redirect()->route('admin.post.list')->with('status', trans('notification.active_success'));
                } elseif ($act == Constants::RESTORE) {
                    DB::table('posts')->whereIn('id', $list_check)->update(['deleted_at' => Constants::EMPTY]);
                    return redirect()->route('admin.post.list')->with('status', trans('notification.restore_success'));
                } elseif ($act == Constants::FORCE_DELETE) {
                    DB::table('posts')->whereIn('id', $list_check)->delete();
                    return redirect()->route('admin.post.list')->with('status', trans('notification.force_delete_success'));
                } else {
                    return redirect()->route('admin.post.list')->with('status', trans('notification.not_action'));
                }
            } else {
                return redirect()->route('admin.post.list')->with('status', trans('notification.not_element'));
            }
        }
    }
}
