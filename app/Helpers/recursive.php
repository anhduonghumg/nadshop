<?php

namespace App\Helpers;

use App\Constants\Constants;

trait Recursive
{
    public function recursive($data, $parent_id = 0, $level = 0)
    {
        $result = [];
        foreach ($data as $item) {
            if ($item['parent_id'] == $parent_id) {
                $item['level'] = $level;
                $result[] = $item;

                unset($data[$item[$parent_id]]);
                $child = $this->recursive($data, $item['id'], $level + 1);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }

    public function dataSelect($model, $column = "status", $field_name = 'name')
    {
        $data_select = [];
        $dataModels = $model::all();
        $dataModels = $this->recursive($dataModels);

        foreach ($dataModels as $data) {
            if ($data[$column] == Constants::PUBLIC && $data['deleted_at'] == Constants::EMPTY)
                $data_select[$data->id] = str_repeat('|---', $data->level) . $data[$field_name];
        }

        return $data_select;
    }

    function menuTree($menu, $parent = 0)
    {
        $str_menu = "<ul class='list-item'>";
        foreach ($menu as $key => $value) {
            $value['url_product_name'] = "{$value['slug']}/{$value['parent_id']}/{$value['product_cat_id']}";
            if ($value['parent_id'] == $parent) {
                $str_menu .= "<li><a href ='{$value['url_product_name']}'>" . $value['product_cat_name'] . "</a>";
                unset($value[$key]);
                $id = $value['product_cat_id'];
                $str_menu .=  "<ul class='sub-menu'>";
                foreach ($menu as $key => $value) {
                    $value['url_product_name'] = "{$value['slug']}/{$value['parent_id']}/{$value['product_cat_id']}";
                    if ($value['parent_id'] != 0 && $value['parent_id'] == $id) {
                        $str_menu .= "<li><a href = '{$value['url_product_name']}'>" . $value['product_cat_name'] . "</a></li>";
                    }
                }
                $str_menu .= "</ul>";
                $str_menu .= "</li>";
            }
        }
        $str_menu .= "</ul>";
        return $str_menu;
    }

    // function breadcrumb($id, $model, $name, $router)
    // {
    //     $output = "";
    //     $get = $model::find($id);
    //     $get_all = $model::select('id')->get()->to_array();
    //     if (in_array($get->parent_id, $get_all)) {
    //         $output .= "<li><a href='{{$router}}'>{{$get->$name}}</a><i
    //         class='fas fa-angle-double-right breadcrumb-icon'></i></li>
    //         <li>{{ $get->name }}</li>";
    //     } else {
    //         $output .= "<li><a href='{{$router}}'>{{$get->$name}}</a></li>";
    //     }
    // }
}
