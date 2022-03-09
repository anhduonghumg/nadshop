<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminCategoryPostController extends Controller
{
    public function __construct()
    {
    }

    public function list()
    {
        $catPosts = CategoryPost::latest()->paginate(20);
        $data_catPosts = recursive($catPosts);
        $data_select = dataSelect(new CategoryPost);
        return view('admin.postCat.list', compact('data_select', 'catPosts', 'data_catPosts'));
    }

    public function add(Request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'name' => 'required|min:5|unique:category_posts',
                ],
                [
                    'required' => 'Tên danh mục không được để trống',
                    'unique' => 'Tên danh mục đã tồn tại',
                    'min' => 'Tên danh mục chứa ít nhất 5 ký tự'
                ]
            );
            CategoryPost::create(
                [
                    'name' => $request->input('name'),
                    'slug' => Str::slug($request->input('name')),
                    'parent_id' => $request->input('parent_id'),
                ]
            );

            return back()->with('status', 'Bạn đã thêm danh mục thành công');
        }
    }

    public function edit($id)
    {
        $catPost = CategoryPost::find($id);

        $data_select = dataSelect(new CategoryPost);
        return view('admin.postCat.edit', compact('catPost', 'data_select'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                // Sẽ vẫn áp dụng rule unique nhưng sẽ bỏ qua bài viết có id là $postId
                'name' => 'required|min:5|unique:category_posts,name,' . $id . ',id',
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'unique' => 'Tên danh mục đã tồn tại',
                'min' => 'Tên danh mục chứa ít nhất 5 ký tự'
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
