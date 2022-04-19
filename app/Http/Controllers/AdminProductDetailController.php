<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminProductDetailController extends Controller
{
    protected $productVariantRepo;
    public function __construct(ColorRepositoryInterface $colorRepo, SizeRepositoryInterface $sizeRepo, ImageRepositoryInterface $imgRepo)
    {
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
            'product_detail_name' => 'email',
            'product_price' => 'required',
            'product_discount' => 'required',
            'product_qty_stock' => 'required',
            'product_color' => 'required',
            'product_size' => 'required',
            'product_details_thumb' => 'required',
        ]);

        if ($validator->passes()) {
            return response()->json(['success' => 'Added new records.']);
        }

        return response()->json(['errors' => $validator->errors()]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()]);
        // } else {
        //     $id = $request->id;
        //     $name = $request->name;
        //     $price = $request->price;
        //     $color = $request->color;
        //     $size = $request->size;
        //     $thumb = $request->thumb;
        //     $qty = $request->qty;
        //     $discount = $request->discount;
        //     foreach ($name as $key => $value) {
        //         $saveData = [
        //             'product_detail_name' => $name[$key],
        //             'product_detail_slug' => Str::slug($name[$key]),
        //             'product_details_thumb' => $thumb[$key],
        //             'product_price' => $price[$key],
        //             'product_discount' => $discount[$key],
        //             'product_qty_stock' => $qty[$key],
        //             'color_id' => $color[$key],
        //             'size_id' => $size[$key],
        //             'user_id' => Auth::id(),
        //             'product_id' => $id,
        //             'created_at' => now(),
        //             'updated_at' => now()
        //         ];
        //         DB::table('product_details')->insert($saveData);
        //     }
        //     return response()->json(['success' => 'Added new records.']);
        // }
    }
}
