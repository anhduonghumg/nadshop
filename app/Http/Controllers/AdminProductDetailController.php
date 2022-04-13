<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;

class AdminProductDetailController extends Controller
{
    public function __construct(ColorRepositoryInterface $colorRepo, SizeRepositoryInterface $sizeRepo)
    {

        $this->colorRepo = $colorRepo;
        $this->sizeRepo = $sizeRepo;
    }

    public function add(Request $request)
    {
        // $id = $request->proId;
        $list_product_color = $this->colorRepo->get_list_color_product();
        $list_product_size = $this->sizeRepo->get_list_size_product();
        $url_add_product_detail = route('admin.product.detail.store');
        $data_image = asset('storage/app/public/images/upload_img.png');
        $result = [
            'list_product_color' => $list_product_color,
            'list_product_size' => $list_product_size,
            'url_add_product' => $url_add_product_detail,
            'data_image' => $data_image
        ];
        return response()->json($result);
    }

    public function store(Request $request)
    {
        if ($request->has('btn_store')) {
        }
    }
}
