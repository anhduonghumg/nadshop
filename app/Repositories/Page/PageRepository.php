<?php

namespace App\Repositories\Page;

use App\Repositories\BaseRepository;

class PageRepository extends BaseRepository implements PageRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Page\Page::class;
    }
}
