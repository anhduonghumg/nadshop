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
}
