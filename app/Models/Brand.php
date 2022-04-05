<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    protected $guarded = [];

    function user()
    {
        return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    }
}
