<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function currentcyFormat($val, $unit = "đ")
{
    $result = number_format($val, 0, '', '.') . $unit;
    return $result;
}

function formatDateToDMY($val)
{
    $result = date('d/m/Y H:i', strtotime($val));
    return $result;
}

function get_order_code()
{
    return '#' . str_pad(time(), 8, "0", STR_PAD_LEFT);
}

function get_address($address, $district, $city)
{
    $result = "{$address}," . "{$district}," . "{$city}";
    return $result;
}

function get_selected($id)
{
    $result = DB::table('permission_roles')->where('role_id', $id)->get();
    return collect($result);
}
