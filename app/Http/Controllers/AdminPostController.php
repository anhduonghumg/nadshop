<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Constants\Constants;
use App\Helpers\ImageUpload;
use App\Helpers\Recursive;
use App\Repositories\Post\PostRepositoryInterface;
use App\Models\M_user;

class AdminPostController extends Controller
{
    use ImageUpload, Recursive;

    protected $postRepo;
    public function __construct(PostRepositoryInterface $postRepo, Post $post, M_user $user)
    {
        $this->postRepo = $postRepo;
        $this->post = $post;
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
            $list_posts = $this->postRepo->get_list_posts_status(Constants::PUBLIC, $key, $paginate = 1, $orderBy = 'id');
        } elseif ($status == Constants::TRASH) {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $list_posts = $this->postRepo->get_list_posts_trash($key, $paginate = 10, $orderBy = "deleted_at");
        } elseif ($status == Constants::PENDING) {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $list_posts = $this->postRepo->get_list_posts_status(Constants::PENDING, $key, $paginate = 1, $orderBy = "id");
        }

        $id = $request->user()->id;
        $get_author = Post::where('user_id', $id)->first();
        $get_author = $get_author->user_id;
        $num_post_active = $this->postRepo->get_num_post_active();
        $num_post_trash = $this->postRepo->get_num_post_trash();
        $num_post_pending = $this->postRepo->get_num_post_pending();
        $count = [$num_post_active, $num_post_trash, $num_post_pending];

        return view('admin.post.list', compact('list_posts', 'count', 'list_act', 'get_author'));
    }

    public function add(Request $request)
    {
        if ($this->authorize('create', $this->post)) {
            $data_category_post = $this->dataSelect(new CategoryPost);
            return view('admin.post.add', compact('data_category_post'));
        }
    }

    public function store(Request $request)
    {
        if ($this->authorize('create', $this->post)) {
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
                    "created_at" => now(),
                    "updated_at" => now(),
                ];

                if ($request->hasFile('thumbnail')) {
                    $file = $request->thumbnail;
                    $dataImg = $this->uploadImage($file, 'post', Auth::id());
                    $data['thumbnail'] = $dataImg;
                }

                $this->postRepo->add($data);
                return redirect()->route('admin.post.list')->with('status', trans('notification.add_success'));
            }
        }
    }
    public function edit(Request $request, $id)
    {
        $get_author = $this->postRepo->find($id);
        $get_author = $get_author->user_id;
        if ($request->user()->can('update', $this->post) || Auth::id() == $get_author) {
            $post = $this->postRepo->get_post_by_id($id, ['title', 'desc', 'content', 'thumbnail', 'post_cat_id']);

            $data_cat_post = $this->dataSelect(new CategoryPost);
            return view('admin.post.edit', compact('post', 'data_cat_post'));
        } else {
            return abort(403);
        }
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
                    'updated_at' => now(),
                ];

                if ($request->hasFile('thumbnail')) {
                    $dataImg = $this->ImageUpload($request->thumbnail, 'post');
                    $data['thumbnail'] = $dataImg['file_path'];
                }

                $this->postRepo->update($data, $id);

                return redirect()->route('admin.post.list')->with('status', trans('notification.update_success'));
            }
        }
    }
    public function delete(Request $request, $id)
    {
        $get_author = $this->postRepo->find($id);
        $get_author = $get_author->user_id;
        if ($request->user()->can('delete', $this->post) || Auth::id() == $get_author) {
            if ($id != null) {
                $data = [
                    'deleted_at' => now()
                ];
                $this->postRepo->delete($data, $id);
                return redirect()->route('admin.post.list')->with('status', trans('notification.delete_success'));
            } else {
                return redirect()->route('admin.post.list')->with('status', trans('notification.no_data'));
            }
        }
    }

    public function forceDelete(Request $request, $id)
    {
        $get_author = $this->postRepo->find($id);
        $get_author = $get_author->user_id;
        if ($request->user()->can('delete', $this->post) || Auth::id() == $get_author) {
            if ($id != null) {
                $this->postRepo->forceDelete($id);
                return redirect()->route('admin.post.list')->with('status', trans('notification.force_delete_success'));
            } else {
                return redirect()->route('admin.post.list')->with('status', trans('notification.no_data'));
            }
        }
    }

    public function action(Request $request)
    {
        if ($request->has('btn_action')) {
            $list_check = $request->input('list_check');
            if ($list_check != null) {
                $act = $request->input('act');
                if ($act == Constants::DELETE) {
                    $data = ['deleted_at' => now()];
                    $this->postRepo->update($data, $list_check);
                    return redirect()->route('admin.post.list')->with('status', trans('notification.delete_success'));
                } elseif ($act == Constants::ACTIVE) {
                    $data = ['status' => Constants::PUBLIC];
                    $this->postRepo->update($data, $list_check);
                    return redirect()->route('admin.post.list')->with('status', trans('notification.active_success'));
                } elseif ($act == Constants::RESTORE) {
                    $data = ['deleted_at' => Constants::EMPTY];
                    $this->postRepo->update($data, $list_check);
                    return redirect()->route('admin.post.list')->with('status', trans('notification.restore_success'));
                } elseif ($act == Constants::FORCE_DELETE) {
                    $this->postRepo->forceDelete($list_check);
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
