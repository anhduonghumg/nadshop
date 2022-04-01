<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

trait Crud
{
    public static function add_model($model, $data)
    {
        return $model::create($data);
    }

    public static function update_model($model, $data, $id)
    {
        if (is_array($id))
            return $model::whereIn('id', $id)->update($data);
        return $model::where('id', $id)->update($data);
    }

    public static function delete_model($model, $id)
    {
        $data = [
            'deleted_at' => now()
        ];
        if (is_array($id))
            return $model::whereIn('id', $id)->update($data);
        return $model::where('id', $id)->update($data);
    }

    public static function forceDelete_model($model, $id)
    {
        if (is_array($id))
            return $model::whereIn('id', $id)->delete();
        return $model::where('id', $id)->delete();
    }
}
