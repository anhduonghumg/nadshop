<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Trait\ImageUpload;

class AdminPostController extends Controller
{
    use ImageUpload;

    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }

    public function list()
    {
        $list_posts = Post::latest()->paginate(20);

        return view('admin.post.list', compact('list_posts'));
    }

    public function add()
    {

        $data_category_post = dataSelect(new CategoryPost);

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
                    // 'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
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
            ];

            Post::Create($data);
            return redirect('admin/post/list')->with('status', 'Đã thêm bài viết thành công.');
        }
    }
}
