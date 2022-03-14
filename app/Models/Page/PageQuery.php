<?php

namespace App\Models\Page;

trait PageQuery
{
    public static function list_page($key)
    {
        return Page::where("name", "LIKE", "%{$key}%");
    }

    public static function add_page($data)
    {
        return Page::create($data);
    }

    public static function update_page($data, $id)
    {
        return Page::where('id', $id)->update($data);
    }

    public static function delete_page($id)
    {
        return Page::find($id)->delete();
    }
}
