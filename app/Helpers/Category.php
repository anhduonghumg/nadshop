<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;


class Category
{
    public static function getNameParent($table, $field, $name)
    {
        $result = DB::table($table)->select($name)->where('id', $field)->first();
        $result = collect($result);
        if ($result->isNotEmpty())
            return $result[$name];
        return false;
    }
}
