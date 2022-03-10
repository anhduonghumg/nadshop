<?php

function recursive($data, $parent_id = 0, $level = 0)
{
    $result = [];
    foreach ($data as $item) {
        if ($item['parent_id'] == $parent_id) {
            $item['level'] = $level;
            $result[] = $item;

            unset($data[$item[$parent_id]]);
            $child = recursive($data, $item['id'], $level + 1);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}

function dataSelect($model)
{
    $data_select = [];
    $data_models = $model::all();
    $data_models = recursive($data_models);

    foreach ($data_models as $data) {
        $data_select[$data->id] = str_repeat('|---', $data->level) . $data->name;
    }

    return $data_select;
}
