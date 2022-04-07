<?php

namespace App\Repositories\Size;

use App\Repositories\BaseRepository;


class SizeRepository extends BaseRepository implements SizeRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Size::class;
    }

    public function get_size_by_id($id, $select = [])
    {

        $size = $this->model
            ->select($select)
            ->firstWhere('id', $id);
        return $size;
    }

    public function get_list_size($paginate = 10, $orderBy = "id")
    {
        $color = $this->model
            ->select('id', 'size_name', 'created_at')
            ->orderByDesc($orderBy)
            ->paginate($paginate);
        return $color;
    }
}
