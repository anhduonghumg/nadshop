<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;

class DistrictController extends Controller
{
    public function __construct()
    {
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $id_city = $request->city;
            $list_district = District::where('city_id', $id_city)->get();

            return response()->json($list_district);
        }
    }
}
