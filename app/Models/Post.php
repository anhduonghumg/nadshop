<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    }

    public function posCat()
    {
        return $this->belongsTo('App\models\CategoryPost', 'post_cat_id', 'id');
    }
}
