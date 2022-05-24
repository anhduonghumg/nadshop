<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\M_user');
    }

    public function postCategory()
    {
        return $this->belongsTo('App\models\CategoryPost', 'post_cat_id', 'id');
    }
}
