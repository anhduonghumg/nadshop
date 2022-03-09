<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'pages';
    protected $fillable = [
        'name',
        'slug',
        'content',
        'user_id',
    ];

    function user()
    {
        return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    }
}
