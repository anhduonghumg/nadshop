<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;

class AdminProductDetailController extends Controller
{
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

        dd($request->fm_data);
    }
}
