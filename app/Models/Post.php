<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // public function User()
    // {
    //     return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    // }

    // public function posCat()
    // {
    //     return $this->belongsTo('App\models\CategoryPost', 'post_cat_id', 'id');
    // }

    public static function get_list_post($field, $operator, $value, $key = '')
    {
        $results = DB::table('posts')
            ->join('M_users', 'M_users.id', '=', 'posts.user_id')
            ->join('category_posts', 'category_posts.id', '=', 'posts.post_cat_id')
            ->select('posts.*', 'M_users.fullname', 'category_posts.name')
            ->where("posts.{$field}", $value)
            ->where('posts.title', 'LIKE', "%{$key}%")
            ->orderBy('posts.created_at', 'desc')
            ->paginate(20);
        return $results;
    }
}
