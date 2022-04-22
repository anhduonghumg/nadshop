<?php

namespace App\Http\Controllers;

use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\ProductDetail\ProductDetailRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminProductDetailController extends Controller
{
    protected $productDetailRepo;

    public function __construct(ProductDetailRepositoryInterface $productDetailRepo, ColorRepositoryInterface $colorRepo, SizeRepositoryInterface $sizeRepo, ImageRepositoryInterface $imgRepo)
    {
        $this->productDetailRepo = $productDetailRepo;
        $this->colorRepo = $colorRepo;
        $this->sizeRepo = $sizeRepo;
        $this->imgRepo = $imgRepo;
    }

    public function add(Request $request)
    {
        $id = $request->proId;
        $list_product_color = $this->colorRepo->get_list_color_product();
        $list_product_size = $this->sizeRepo->get_list_size_product();
        $list_image = $this->imgRepo->get_list_image_product($id);
        $url_add_product_detail = route('admin.product.detail.store');
        $result = [
            'list_product_color' => $list_product_color,
            'list_product_size' => $list_product_size,
            'url_add_product' => $url_add_product_detail,
            'id_product' => $id,
            'list_image' => $list_image
        ];
        return response()->json($result);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_detail_name.*' => 'bail|required',
            'product_price.*' => 'bail|required|numeric',
            'product_discount.*' => 'bail|required|numeric',
            'product_qty_stock.*' => 'bail|required|numeric',
            'product_color.*' => 'bail|required',
            'product_size.*' => 'bail|required',
            'product_details_thumb.*' => 'bail|required',
        ]);

        if ($validator->fails()) {
            $error = collect($validator->errors())->unique()->first();
            return response()->json(['errors' => $error]);
        }

        foreach ($request->product_detail_name as $key => $value) {
            $saveData = [
                'product_detail_name' => $request->product_detail_name[$key],
                'product_detail_slug' => Str::slug($request->product_detail_name[$key]),
                'product_details_thumb' => $request->product_details_thumb[$key],
                'product_price' => $request->product_price[$key],
                'product_discount' => $request->product_discount[$key],
                'product_qty_stock' => $request->product_qty_stock[$key],
                'color_id' => $request->product_color[$key],
                'size_id' => $request->product_size[$key],
                'user_id' => Auth::id(),
                'product_id' => $request->id,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $this->productDetailRepo->add($saveData);
        }
        return response()->json(['success' => trans('notification.add_success')]);
    }

    public function list()
    {
        $list_product_details = $this->productDetailRepo->get_list_product_details();
        return view('admin.productDetail.list', compact('list_product_details'));
    }

    public function edit(Request $request)
    {
        $id = $request->proId;
        $product = $this->productDetailRepo->get_product_detail_by_id($id, ['*']);
        $pro_id = isset($product) ? $product->product_id : '0';
        $list_product_color = $this->colorRepo->get_list_color_product();
        $list_product_size = $this->sizeRepo->get_list_size_product();
        $list_image = $this->imgRepo->get_list_image_product($pro_id);
        $url_update = route('admin.product.detail.update');

        $result = [
            'list_product_color' => $list_product_color,
            'list_product_size' => $list_product_size,
            'id_product' => $id,
            'list_image' => $list_image,
            'product_detail' => $product,
            'url_update' => $url_update
        ];
        return response()->json($result);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'product_detail_name' => 'bail|required',
            'product_price' => 'bail|required|numeric',
            'product_discount' => 'bail|required|numeric',
            'product_qty_stock' => 'bail|required|numeric',
            'product_color' => 'bail|required',
            'product_size' => 'bail|required',
            'product_details_thumb' => 'bail|required',
        ]);

        if ($validator->fails()) {
            $error = collect($validator->errors())->unique()->first();
            return response()->json(['errors' => $error]);
        }

        $saveData = [
            'product_detail_name' => $request->product_detail_name,
            'product_detail_slug' => Str::slug($request->product_detail_name),
            'product_details_thumb' => $request->product_details_thumb,
            'product_price' => $request->product_price,
            'product_discount' => $request->product_discount,
            'product_qty_stock' => $request->product_qty_stock,
            'color_id' => $request->product_color,
            'size_id' => $request->product_size,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $this->productDetailRepo->update($saveData, $id);
        return response()->json(['success' => trans('notification.update_success')]);
    }


    public function delete(Request $request)
    {
        $id = $request->id;
        if ($id != null) {
            $this->productDetailRepo->forceDelete($id);
            return response()->json(['success' => trans('notification.force_delete_success')]);
        }
        return response()->json(['errors' => trans('notification.no_data')]);
    }
}
