<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Statistical;

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

    public function chart()
    {
        return view('admin.test.chart');
    }

    public function filter_by_date(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $from_date = $data['from_date'];
            $to_date = $data['to_date'];

            $get = Statistical::whereBetween('date', [$from_date, $to_date])
                ->orderBy('date', 'ASC')
                ->get();

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->date,
                    'order' => $val->total_order,
                    'sales' => $val->sales,
                    'profit' => $val->profit,
                    'qty' => $val->qty,
                );
            }
            echo $data = json_encode($chart_data);
        }
    }
}
