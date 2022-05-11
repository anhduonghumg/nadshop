<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'user_districts';
    public $timestamps = false;
    protected $guarded = [];

    public function get_name_city($id)
    {
        if ($id != null) {
            $result = District::findOrFail($id);
            return $result;
        }
    }
}
