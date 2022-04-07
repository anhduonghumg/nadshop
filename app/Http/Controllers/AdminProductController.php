<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Models\Brand;
use App\Helpers\ImageUpload;
use App\Helpers\Recursive;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function list(Request $request)
    {
        $status = $request->input('status');
        $key = isset($request->kw) ? $request->kw : "";
        if (!$status || $status == Constants::ACTIVE) {
            $list_act = ['delete' => 'Xóa'];
            $list_products = $this->productRepo->get_list_products_status(Constants::PUBLIC, $key, $paginate = 10, $orderBy = 'id');
        } elseif ($status == Constants::TRASH) {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $list_products = $this->productRepo->get_list_products_trash($key, $paginate = 10, $orderBy = "deleted_at");
        } elseif ($status == Constants::PENDING) {
            $list_act = ['active' => 'Duyệt', 'delete' => 'Xóa'];
            $list_products = $this->productRepo->get_list_products_status(Constants::PENDING, $key, $paginate = 10, $orderBy = "id");
        }

        $num_product_active = $this->productRepo->get_num_product_active();
        $num_product_trash = $this->productRepo->get_num_product_trash();
        $num_product_pending = $this->productRepo->get_num_product_pending();
        $count = [$num_product_active, $num_product_trash, $num_product_pending];

        return view('admin.product.list', compact('list_products', 'count', 'list_act'));
    }

    public function add()
    {
        $data_category_product = $this->dataSelect(new CategoryProduct, 'category_product_status', 'category_product_name');
        $data_brand = $this->dataSelect(new Brand, 'status', 'brand_name');
        return view('admin.product.add', compact('data_category_product', 'data_brand'));
    }

    public function store(Request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'product_name' => ['required', 'string', 'max:255', 'unique:products'],
                    'product_desc' => ['required', 'string'],
                    'product_status' => ['required'],
                    'product_content' => ['required', 'string'],
                    'product_thumb' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    'category_product' => ['required'],
                    'brand' => ['required'],
                ]
            );

            $data = [
                'product_name' => $request->input('product_name'),
                'product_slug' => Str::slug($request->input('product_name')),
                'product_desc' => $request->input('product_desc'),
                'product_status' => $request->input(('product_status')),
                'product_content' => $request->input('product_content'),
                'user_id' => Auth::id(),
                'brand_id' => $request->input('brand'),
                'product_cat_id' => $request->input('category_product'),
                "created_at" => now(),
                "updated_at" => now(),
            ];

            if ($request->hasFile('product_thumb')) {
                $dataImg = $this->ImageUpload($request->product_thumb, 'product');
                $data['product_thumb'] = $dataImg['file_path'];
            }

            $this->productRepo->add($data);
            return redirect()->route('admin.product.list')->with('status', trans('notification.add_success'));
        }
    }

    public function edit($id)
    {
        $product = $this->productRepo->get_product_by_id($id, ['id', 'product_name', 'product_desc', 'product_content', 'product_thumb', 'product_cat_id', 'brand_id']);
        $data_category_product = $this->dataSelect(new CategoryProduct, 'category_product_status', 'category_product_name');
        $data_brand = $this->dataSelect(new Brand, 'status', 'brand_name');
        return view('admin.product.edit', compact('product', 'data_category_product', 'data_brand'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has('btn_update')) {
            $request->validate(
                [
                    'product_name' => ['required', 'string', 'max:255', 'unique:products,product_name,' . $id . ',id'],
                    'product_desc' => ['required', 'string'],
                    'product_content' => ['required', 'string'],
                    'product_thumb' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    'category_product' => ['required'],
                    'brand' => ['required'],
                ]
            );

            $data = [
                'product_name' => $request->input('product_name'),
                'product_slug' => Str::slug($request->input('product_name')),
                'product_desc' => $request->input('product_desc'),
                'product_content' => $request->input('product_content'),
                'user_id' => Auth::id(),
                'brand_id' => $request->input('brand'),
                'product_cat_id' => $request->input('category_product'),
                "created_at" => now(),
                "updated_at" => now(),
            ];

            if ($request->hasFile('product_thumb')) {
                $dataImg = $this->ImageUpload($request->product_thumb, 'product');
                $data['product_thumb'] = $dataImg['file_path'];
            }

            $this->productRepo->update($data, $id);
            return redirect()->route('admin.product.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            $data = [
                'deleted_at' => now()
            ];
            $this->productRepo->delete($data, $id);
            return back()->with('status', trans('notification.delete_success'));
        } else {
            return back()->with('status', trans('notification.no_data'));
        }
    }

    public function forceDelete($id)
    {
        if ($id != null) {
            $this->productRepo->forceDelete($id);
            return back()->with('status', trans('notification.force_delete_success'));
        } else {
            return back()->with('status', trans('notification.no_data'));
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
                    $this->productRepo->update($data, $list_check);
                    return redirect()->route('admin.product.list')->with('status', trans('notification.delete_success'));
                } elseif ($act == Constants::ACTIVE) {
                    $data = ['product_status' => Constants::PUBLIC];
                    $this->productRepo->update($data, $list_check);
                    return redirect()->route('admin.product.list')->with('status', trans('notification.active_success'));
                } elseif ($act == Constants::RESTORE) {
                    $data = ['deleted_at' => Constants::EMPTY];
                    $this->productRepo->update($data, $list_check);
                    return redirect()->route('admin.product.list')->with('status', trans('notification.restore_success'));
                } elseif ($act == Constants::FORCE_DELETE) {
                    $this->productRepo->forceDelete($list_check);
                    return redirect()->route('admin.product.list')->with('status', trans('notification.force_delete_success'));
                } else {
                    return redirect()->route('admin.product.list')->with('status', trans('notification.not_action'));
                }
            } else {
                return redirect()->route('admin.product.list')->with('status', trans('notification.not_element'));
            }
        }
    }
}
