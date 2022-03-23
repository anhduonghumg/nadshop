<?php

namespace App\Models;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use App\Constants\Constants;

class M_user extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'm_users';

    protected $fillable = [
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

    public static function get_list_users_trash()
    {
        $result = DB::table('m_users')
            ->where('deleted_at', '<>', Constants::EMPTY)
            ->orderBy('deleted_at', 'desc')
            ->paginate(20);
        return $result;
    }

    public static function get_list_users($keyword)
    {
        $result = DB::table('m_users')
            ->where('deleted_at', '=', Constants::EMPTY)
            ->where("fullname", "LIKE", "%{$keyword}%")
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return $result;
    }

    public static function add_user($data)
    {
        $result = DB::insert($data);
        return $result;
    }

    // Thay đổi mail mặc định
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
