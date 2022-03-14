<?php

namespace App\Trait;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


trait ImageUpload
{
    public function ImageUpload($query)
    {
        $image_name = str::random(20);
        $ext = strtolower($query->getClientOriginalExtension());
        $image_full_name = $image_name . '.' . $ext;
        $upload_path = 'public/storage/images';
        $image_url = $upload_path . $image_full_name;
        $success = $query->move($upload_path, $image_full_name);

        return $image_url;
    }
}
