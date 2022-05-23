<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;
    public $table = 'role_users';
    public $timestamps = false;
    protected $guarded = [];


    public function get_role($id)
    {
        $result = $this->select('roles.role_name')
            ->join('m_users', 'role_users.user_id', '=', 'm_users.id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('m_users.id', $id)
            ->first();
        return $result;
    }
}
