<?php

namespace App\Models;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\ResetPasswordNotification;
use App\Traits\HasPermissions;

class M_user extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissions;
    protected $table = 'm_users';
    protected $fillable = [
        'id',
        'fullname',
        'username',
        'phone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    // }

    // Thay đổi mail mặc định
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function post()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
}
