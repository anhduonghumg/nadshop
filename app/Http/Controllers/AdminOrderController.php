<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\District;
use App\Models\OrderStatus;
use App\Repositories\ProductDetail\ProductDetailRepositoryInterface;

class AdminOrderController extends Controller
{
    protected $product;
    protected $city;
    protected $district;
    public function __construct(
        ProductDetailRepositoryInterface $product,
        City $city,
        OrderStatus $status
    ) {
        $this->product = $product;
        $this->status = $status;
        $this->city = $city;
    }

    public function list()
    {
        return view('admin.order.list');
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            $id = isset($request->product) ? $request->product : null;
            $product = $this->product->get_product_detail_by_id($id, ['product_price']);
            return response()->json(['product' => $product]);
        }
        $list_city = $this->city->all();
        $list_status = $this->status->all();
        $list_product =  $this->product->get('id', 'product_detail_name');
        return view('admin.order.add', compact('list_city', 'list_status', 'list_product'));
    }

    public function loadDistrict(Request $request)
    {
        if ($request->ajax()) {
            $id_city = $request->city;
            $list_district = District::where('city_id', $id_city)->get();
            return view('admin.order.district', compact('list_district'))->render();
        }
    }

    public function loadProduct(Request $request)
    {
        if ($request->ajax()) {
            $list_product =  $this->product->get('id', 'product_detail_name');
            $result = [
                'list_product' => $list_product
            ];
            return response()->json($result);
        }
    }
}
