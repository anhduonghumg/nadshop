<?php

namespace App\Repositories\Color;

use App\Repositories\BaseRepository;


class ColorRepository extends BaseRepository implements ColorRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Color::class;
    }

    public function get_color_by_id($id, $select = [])
    {

        $color = $this->model
            ->select($select)
            ->firstWhere('id', $id);
        return $color;
    }

    public function get_list_color($paginate = 10, $orderBy = "id")
    {
        $color = $this->model
            ->select('id', 'color_name', 'created_at')
            ->orderByDesc($orderBy)
            ->paginate($paginate);
        return $color;
    }

    public function get_list_color_product()
    {
        $color = $this->model
            ->select('id', 'color_name')
            ->orderByDesc('id')
            ->get();
        return $color;
    }
}
