<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Models\Brand;
use App\Helpers\ImageUpload;
use App\Helpers\Recursive;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AdminProductController extends Controller
{
    use ImageUpload, Recursive;
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;

        $this->middleware(function (Request $request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    public function list()
    {
    }

    public function add()
    {
        $data_category_product = $this->dataSelect(new CategoryProduct, 'category_product_status', 'category_product_name');
        $data_brand = $this->dataSelect(new Brand, 'status', 'brand_name');
        return view('admin.product.add', compact('data_category_product', 'data_brand'));
    }

    public function store(request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'product_name' => ['required', 'string', 'max:255', 'unique:products'],
                    'product_desc' => ['required', 'string'],
                    'product_content' => ['required', 'string'],
                    'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    'category_product' => ['required'],
                    'brand' => ['required'],
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
                $dataImg = $this->ImageUpload($request->thumbnail, 'product');
                $data['thumbnail'] = $dataImg['file_path'];
            }

            $this->postRepo->add($data);
            return redirect()->route('admin.post.list')->with('status', trans('notification.add_success'));
        }
    }
}
