<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

trait Check
{
    public function check_parent_cat($table, $id)
    {
        $get_all = DB::table($table)->get();
        $get_cat_by_id = DB::table($table)->where('id', $id)->first();
        foreach ($get_all as $item) {
            if ($get_cat_by_id->id == $item->parent_id)
                return true;
        }
        return false;
    }
}
