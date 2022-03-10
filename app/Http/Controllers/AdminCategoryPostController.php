<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminCategoryPostController extends Controller
{
    public function __construct()
    {
    }

    public function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = ['delete' => 'Xóa tạm thời'];
        if ($status == 'trash') {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $category_post = CategoryPost::onlyTrashed()->paginate(10);
        } elseif ($status == 'active') {
            $list_act = ['delete' => 'Xóa tạm thời'];
            $category_post = CategoryPost::where('status', 'public')->paginate(10);
        } elseif ($status == 'pending') {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa tạm thời'];
            $category_post = CategoryPost::where('status', 'pending')->paginate(10);
        } else {
            $category_post = CategoryPost::latest()->paginate(15);
        }

        $data_cat_post = dataSelect(new CategoryPost);
        $count_page_active = CategoryPost::where('status', 'public')->count();
        $count_page_trash = CategoryPost::onlyTrashed()->count();
        $count_page_pending = CategoryPost::Where('status', 'pending')->count();
        $count = [$count_page_active, $count_page_trash, $count_page_pending];

        return view('admin.catPost.list', compact('category_post', 'data_cat_post', 'count', 'list_act'));
    }

    public function add(Request $request)
    {
        if ($request->has('btn_add')) {

            $request->validate(
                [
                    'name' => 'required|string|max:255|unique:category_posts',
                ],
                [
                    'required' => ':attribute không được để trống.',
                    'max' => ':attribute không được để trống có độ dài ít nhất :max kí tự.',
                    'unique' => ':attribute đã tồn tại.',
                    'string' => ':attribute phải là một chuỗi'
                ],
                [
                    'name' => 'Tên danh mục'
                ]
            );

            CategoryPost::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'status' => $request->input('status'),
                'parent_id' => $request->input('parent_id'),
                'user_id' => Auth::id()
            ]);

            return redirect('admin/post/cat/list')->with('status', 'Bạn đã thêm danh mục thành công');
        }
    }

    public function edit($id)
    {
        if (!isset($id) || $id == 0) {
            return redirect('admin/post/cat/list');
        } else {
            $catPost = CategoryPost::find($id);
            $data_cat_post = dataSelect(new CategoryPost);
        }
        return view('admin.catPost.edit', compact('catPost', 'data_cat_post'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has('btn_update')) {
            $request->validate(
                [
                    'name' => 'required|string|max:255|unique:category_posts,name,' . $id . ',id',
                ],
                [
                    'required' => ':attribute không được để trống.',
                    'max' => ':attribute không được để trống có độ dài ít nhất :max kí tự.',
                    'unique' => ':attribute đã tồn tại.',
                    'string' => ':attribute phải là một chuỗi'
                ],
                [
                    'name' => 'Tên danh mục'
                ]
            );
            CategoryPost::find($id)->update([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->name),
                'parent_id' => $request->input('parent_id')
            ]);

            return redirect()->route('admin.catPost.list')->with('status', 'Bạn đã cập nhật danh mục thành công');
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            $catPost = CategoryPost::find($id);
            if ($catPost->status == 'public' && CategoryPost::check_parent_post_cat($id)) {
                return redirect('admin/post/cat/list')->with('status', 'Bạn phải xóa danh mục con trước.');
            } else {
                $catPost->delete();
            }
            return redirect('admin/post/cat/list')->with('status', 'Xóa danh mục thành công.');
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
                if ($act == 'delete') {
                    CategoryPost::destroy($list_check);
                    return redirect('admin/post/cat/list')->with('status', 'Bạn đã xóa thành công.');
                } elseif ($act == 'restore') {
                    CategoryPost::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/post/cat/list')->with('status', 'Bạn đã khôi phục thành công.');
                } elseif ($act == 'active') {
                    CategoryPost::whereIn('id', $list_check)->update(['status' => 'public']);
                    return redirect('admin/post/cat/list')->with('status', 'Bạn đã kích hoạt trang thành công.');
                } elseif ($act == 'forceDelete') {
                    CategoryPost::withTrashed()->whereIn('id', $list_check)->forceDelete();
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
