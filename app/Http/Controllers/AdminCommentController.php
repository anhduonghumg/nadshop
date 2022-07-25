<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class AdminCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'comment']);

            return $next($request);
        });
    }

    public function show()
    {
        $list_comment = Comment::select('comments.id', 'comments.comment', 'comments.comment_date', 'comment_name', 'comment_status', 'products.product_name', 'products.id as product_id', 'comment_parent')
            ->leftJoin('products', 'products.id', '=', 'comments.comment_product_id')
            ->where('comments.comment_parent', 0)
            ->orderByDesc('comments.id')
            ->paginate(30);
        $comment_rep = Comment::select('comments.id', 'comments.comment', 'comments.comment_date', 'comment_name', 'comment_status', 'products.product_name', 'products.id as product_id', 'comment_parent')
            ->leftJoin('products', 'products.id', '=', 'comments.comment_product_id')
            ->where('comments.comment_parent', '>', 0)
            ->orderByDesc('comments.id')
            ->get();
        return view('admin.comment.list', compact('list_comment', 'comment_rep'));
    }

    public function approve(Request $request)
    {
        if ($request->ajax()) {
            $status = (int)$request->status;
            $comment = (int)$request->comment;

            $data = [
                'comment_status' => $status,
            ];
            $update = Comment::where('id', $comment)->update($data);
            if ($update) {
                return response()->json(['success' => 'Thành công']);
            }
            return response()->json(['erros' => 'Thất bại']);
        }
    }

    public function reply(Request $request)
    {
        if ($request->ajax()) {

            $comment_content = $request->comment;
            $comment_id = (int)$request->comment_id;
            $product_id = (int)$request->comment_product_id;

            if ($comment_content == '') {
                return response()->json(['errors' => 'Bạn chưa nhập nội dung trả lời']);
            }

            $data = [
                'comment' => $comment_content,
                'comment_date' => now(),
                'comment_name' => 'Admin NadShop',
                'comment_status' => 1,
                'comment_product_id' => $product_id,
                'comment_parent' => $comment_id
            ];
            Comment::create($data);
            return response()->json(['success' => 'Trả lời bình luận thành công']);
        }
    }
}
