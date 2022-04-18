<?php

namespace App\Repositories\Image;

use App\Repositories\RepositoryInterface;

interface ImageRepositoryInterface extends RepositoryInterface
{
    public function get_list_image_product($id);
}
