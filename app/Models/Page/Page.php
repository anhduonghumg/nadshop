<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Constants\Constants;

class Page extends Model
{
    use HasFactory;
    protected $table = 'pages';
    protected $fillable = [
        'page_name',
        'slug',
        'desc',
        'content',
        'status',
        'user_id'
    ];

    public function User()
    {
        return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    }
}
