<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helpers
{
    public static function get_name_parent_category($table, $column)
    {
        $result = DB::table($table)->select('name')->where('id', $column)->first();
        return $result;
    }
}
