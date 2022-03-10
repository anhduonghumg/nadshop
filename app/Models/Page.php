<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'desc',
        'content',
        'status',
        'user_id',
    ];

    function user()
    {
        return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    }
}
