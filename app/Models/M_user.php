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
use App\Constants\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class M_user extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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

    public static function get_list_users_trash()
    {
        $result = M_user::select('id', 'fullname', 'email', 'role_id', 'created_at')
            ->onlyTrashed()
            ->paginate(20);
        return $result;
    }

    public static function get_list_users($keyword)
    {

        $result = M_user::select('id', 'fullname', 'email', 'role_id', 'created_at')
            ->where('deleted_at', '=', Constants::EMPTY)
            ->where('fullname', 'LIKE', "%{$keyword}%")
            ->orderByDesc('id')
            ->paginate(20);
        return $result;
    }

    public static function add_user($data)
    {
        $result = M_user::create($data);
        return $result;
    }

    public static function yourself($data)
    {
        if ($data->isNotEmpty()) {
            $data->each(function ($value, $key) use ($data) {
                if ($data->contains(Auth::id())) {
                    $data->forget($key);
                }
                return false;
            });
        }
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
