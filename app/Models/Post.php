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
        return $this->belongsTo(M_user::class, 'user_id');
    }

    public function postCategory()
    {
        return $this->belongsTo('App\models\CategoryPost', 'post_cat_id', 'id');
    }
}
