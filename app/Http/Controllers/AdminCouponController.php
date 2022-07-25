<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'coupon']);

            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $status = $request->input('status');
        if (!$status || $status == 'on') {
            $list_coupons = Coupon::where('status', 'on')->paginate(20);
        } else {
            $list_coupons = Coupon::where('status', 'off')->paginate(20);
        }
        return view('admin.coupon.list', compact('list_coupons'));
    }

    public function add(Request $request)
    {
        if ($request->has('coupon_add')) {
            $request->validate(
                [
                    'code' => 'required|max:100|unique:coupons',
                    'value' => 'required|numeric',
                    'qty' => 'required|numeric',
                    'status' => 'required'
                ],
            );

            $data = [
                'code' => $request->code,
                'value' => $request->value,
                'qty' => $request->qty,
                'status' => $request->status
            ];

            Coupon::create($data);
            return back()->with('status', trans('notification.add_success'));
        }
    }

    public function edit(Request $request, $id)
    {
        if ($id != null) {
            $coupon = Coupon::find($id);
            return view('admin.coupon.edit', compact('coupon'));
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->has('coupon_update')) {
            $request->validate(
                [
                    'code' => 'required|max:100|unique:coupons,code,' . $id . ',id',
                    'value' => 'required|numeric',
                    'qty' => 'required|numeric',
                    'status' => 'required'
                ],
            );

            $data = [
                'code' => $request->code,
                'value' => $request->value,
                'qty' => $request->qty,
                'status' => $request->status
            ];

            Coupon::where('id', $id)->update($data);
            return redirect()->route('admin.coupon.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            Coupon::find($id)->delete();
            return redirect()->route('admin.coupon.list')->with('status', trans('notification.force_delete_success'));
        }
    }
}
