<?php

namespace App\Models\Page;

trait PageRelationship
{
    public function User()
    {
        return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    }
}
