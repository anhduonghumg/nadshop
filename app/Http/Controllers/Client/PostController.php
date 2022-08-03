<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CategoryProduct;
use App\Constants\Constants;

class PostController extends Controller
{
    public function __construct(CategoryProduct $cat)
    {
        $this->cat = $cat;
    }

    public function show()
    {
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        $list_posts = Post::where('status', 'public')->where('deleted_at', Constants::EMPTY)->paginate(20);
        return view('client.post.show', compact('list_posts', 'category_products'));
    }

    public function detail($id)
    {
        $post = Post::join('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
            ->where('posts.id', $id)
            ->where('posts.status', 'public')
            ->select('posts.*', 'category_posts.name as category_post_name')
            ->first();
        $category_products = $this->cat->where('deleted_at', Constants::EMPTY)->get();
        return view('client.post.detail', compact('post', 'category_products'));
    }
}
