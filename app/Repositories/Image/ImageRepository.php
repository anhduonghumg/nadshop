<?php

namespace App\Repositories\Image;

use App\Repositories\BaseRepository;
use App\Constants\Constants;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Image::class;
    }

    public function get_list_image_product($id)
    {
        $list_img = $this->model
            ->select('id', 'img_name', 'image')
            ->where('product_id', $id)
            ->orderByDesc('id')
            ->get();
        return $list_img;
    }
}
