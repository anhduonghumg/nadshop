<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    protected $guarded = [];

    function catPostChild()
    {
        return $this->hasMany(CategoryPost::class, 'parent_id');
    }

    function catPostParent()
    {
        return $this->belongsTo(CategoryPost::class, 'parent_id');
    }

    public static function check_parent_post_cat($id)
    {
        $postCatALL = CategoryPost::all();
        $postCat = CategoryPost::find($id);
        foreach ($postCatALL as $pc) {
            if ($postCat->id == $pc->parent_id)
                return true;
        }
        return false;
    }
}
