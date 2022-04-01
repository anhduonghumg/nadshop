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

    public static function list_page($key)
    {
        return Page::where("page_name", "LIKE", "%{$key}%");
    }

    public static function get_page_by_id($id)
    {
        $page = Page::select('id', 'page_name', 'desc', 'content')->firstWhere('id', $id);
        return $page;
    }

    public static function get_list_page_trash($paginate = 10)
    {
        $page = Page::select('id', 'page_name', 'status', 'user_id', 'created_at', 'deleted_at')
            ->where('deleted_at', '<>', Constants::EMPTY)
            ->orderByDesc('deleted_at')
            ->paginate($paginate);
        return $page;
    }

    public static function get_list_page_by_status($status, $key = "", $paginate = 10, $order = 'id')
    {
        $page = Page::select('id', 'page_name', 'status', 'user_id', 'created_at')
            ->where('status', "{$status}")
            ->where('deleted_at', '=', Constants::EMPTY)
            ->where('page_name', 'LIKE', "%{$key}%")
            ->orderByDesc($order)
            ->paginate($paginate);
        return $page;
    }

    public static function add_page($data)
    {
        return Page::create($data);
    }

    public static function update_page($data, $id)
    {
        if (is_array($id))
            return Page::whereIn('id', $id)->update($data);
        return Page::where('id', $id)->update($data);
    }

    public static function delete_page($id)
    {
        $data = [
            'deleted_at' => now()
        ];
        if (is_array($id))
            return Page::whereIn('id', $id)->update($data);
        return Page::where('id', $id)->update($data);
    }

    public static function forceDelete_page($id)
    {
        if (is_array($id))
            return Page::whereIn('id', $id)->delete();
        return Page::where('id', $id)->delete();
    }

    public function User()
    {
        return $this->belongsTo('App\models\M_user', 'user_id', 'id');
    }
}
