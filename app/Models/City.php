<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'user_cities';
    public $timestamps = false;
    protected $guarded = [];

    public function get_name_city($id)
    {
        if ($id != null) {
            $result = City::findOrFail($id);
            return $result;
        }
    }
}
