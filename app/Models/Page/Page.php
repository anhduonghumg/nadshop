<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes, PageRelationship, PageQuery;
    protected $table = 'pages';
    protected $fillable = [
        'name',
        'slug',
        'desc',
        'content',
        'status',
        'user_id'
    ];
}
