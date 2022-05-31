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

function menu($menu, $parent = 0)
{
    $str_menu = "";
    foreach ($menu as $key => $value) {
        $str_menu .= "<div class='nav-item dropdown'>";
        $value['url'] = "";
        if ($value['parent_id'] == $parent) {
            $str_menu .= "<a href='#' class='nav-link dropdown-toggle' data-toggle='dropdown'>" . $value['category_product_name'] . "</a>";
            unset($value[$key]);
            $id = $value['id'];
            foreach ($menu as $key => $value) {
                $str_menu .= "<div class='dropdown-menu rounded-0 m-0'>";
                $value['url'] = '';
                if ($value['parent_id'] != $parent && $value['parent_id'] == $id) {
                    $str_menu .= "<a href='#' class='dropdown-item'>" . $value['category_product_name'] . "</a>";
                }
                $str_menu .= "</div>";
            }
        }
        $str_menu .= "</div>";
    }
    return $str_menu;
}
