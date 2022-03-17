<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helpers
{
    public static function get_name_parent_cat($table, $column, $name)
    {
        $result = DB::table($table)->get();
        foreach ($result as $item) {
            if ($column == $item->id)
                return $item->$name;
        }
    }
}
