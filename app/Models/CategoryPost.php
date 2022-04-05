<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class CategoryPost extends Model
{
    use HasFactory;
    protected $table = 'category_posts';
    protected $guarded = [];

    function catPostChild()
    {
        return $this->hasMany(CategoryPost::class, 'parent_id');
    }

    function catPostParent()
    {
        return $this->belongsTo(CategoryPost::class, 'parent_id');
    }

    function user()
    {
        return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    }

    function post()
    {
        return $this->hasMany('App\models\Post');
    }
}
