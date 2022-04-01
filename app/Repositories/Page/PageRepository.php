<?php

namespace App\Repositories\Page;

use App\Repositories\BaseRepository;

class PageRepository extends BaseRepository
{
    public function getModel()
    {
        return App\Models\Page::class;
    }
}
