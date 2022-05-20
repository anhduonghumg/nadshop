<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermiss extends Model
{
    use HasFactory;
    public $table = 'permission_roles';
    public $timestamps = false;
    protected $guarded = [];
}
