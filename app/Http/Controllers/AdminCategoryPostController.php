<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminCategoryPostController extends Controller
{
    public function __construct()
    {
    }

    public function list(Request $request)
    {
        $status = $request->input('status');

        if ($status == 'trash') {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $category_post = CategoryPost::onlyTrashed()->paginate(10);
        } elseif ($status == 'pending') {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $category_post = CategoryPost::where('status', 'pending')->paginate(10);
        } elseif ($status == 'active') {
            $list_act = ['delete' => 'Xóa'];
            $category_post = CategoryPost::where('status', 'public')->paginate(10);
        } else {
            $list_act = ['delete' => 'Xóa'];
            $category_post = CategoryPost::latest()->paginate(10);
        }

        $num_postCat_active = CategoryPost::where('status', 'public')->count();
        $num_postCat_trash = CategoryPost::onlyTrashed()->count();
        $num_postCat_pending = CategoryPost::where('status', 'pending')->count();
        $count = [$num_postCat_active, $num_postCat_trash, $num_postCat_pending];
        $data_cat_post = dataSelect(new CategoryPost);
        return view('admin.catPost.list', compact('category_post', 'data_cat_post', 'count', 'list_act'));
    }

    public function add(Request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'name' => 'required|max:100|unique:category_posts',
                ],
                [
                    'required' => 'Tên danh mục không được để trống',
                    'unique' => 'Tên danh mục đã tồn tại',
                    'max' => 'Tên danh mục tối đa nhất 100 ký tự'
                ]
            );
            CategoryPost::create(
                [
                    'name' => $request->input('name'),
                    'slug' => Str::slug($request->input('name')),
                    'status' => $request->input('status'),
                    'parent_id' => $request->input('parent_id'),
                    'user_id' => Auth::id(),
                ]
            );

            return back()->with('status', 'Bạn đã thêm danh mục thành công');
        }
    }

    public function edit($id)
    {
        $catPost = CategoryPost::find($id);

        $data_cat_post = dataSelect(new CategoryPost);
        return view('admin.catPost.edit', compact('catPost', 'data_cat_post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|max:100|unique:category_posts,name,' . $id . ',id',
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'unique' => 'Tên danh mục đã tồn tại',
                'max' => 'Tên danh mục tối đa nhất 100 ký tự'
            ]
        );

        CategoryPost::find($id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('admin.catPost.list')->with('status', 'Bạn đã cập nhật danh mục thành công');
    }

    public function delete($id)
    {
        if ($id != null) {
            $catPost = CategoryPost::find($id);
            if (CategoryPost::check_parent_post_cat($id)) {
                return redirect('admin/post/cat/list')->with('status', 'Bạn phải xóa danh mục con trước.');
            } else {
                $catPost->delete();
            }
            return redirect('admin/post/cat/list')->with('status', 'Xóa danh mục thành công.');
        } else {
            return redirect('admin/post/cat/list')->with('status', 'Không có dữ liệu.');
        }
    }
}
