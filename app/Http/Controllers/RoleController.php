<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
    }

    public function add()
    {

        return view('admin.role.add');
    }


    public function list()
    {
    }
}
