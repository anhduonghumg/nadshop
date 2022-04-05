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
}
