<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    public function list()
    {
    }

    public function add()
    {
        return view('admin.product.detail');
    }
}
