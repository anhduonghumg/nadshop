<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;

class AdminProductDetailController extends Controller
{
    public function __construct(ColorRepositoryInterface $colorRepo, SizeRepositoryInterface $sizeRepo)
    {
        // $this->productRepo = $productRepo;
        $this->colorRepo = $colorRepo;
        $this->sizeRepo = $sizeRepo;

        $this->middleware(function (Request $request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    public function add(Request $request)
    {
        $id = $request->proId;
        $list_product_color = $this->colorRepo->get_list_color_product();
        $list_product_size = $this->sizeRepo->get_list_size_product();
        $result = [
            'list_product_color' => $list_product_color,
            'list_product_size' => $list_product_size,
            'id' => $id
        ];
        return response()->json($result);
    }
}
