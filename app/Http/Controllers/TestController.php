<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        if ($request->ajax()) {
            $id_city = $request->city;
            $district = District::where('city_id', $id_city)->get();
            return view('admin.test.district', compact('district'))->render();
            // $result = ['district' => $district];
            // return response()->json($result);
        }

        $city = City::all();
        return view('admin.test.test', compact('city'));
    }
}
