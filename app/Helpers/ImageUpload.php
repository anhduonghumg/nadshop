<?php

namespace App\Helpers;

use App\Constants\Constants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait ImageUpload
{

    public function uploadImage($file, $folder, $id)
    {
        $file = $file;
        $upload_dir =  Constants::PATH_IMAGE . "$folder/$id/";
        $file_name = $file->getClientOriginalName();
        $file_extension = $file->getClientOriginalExtension();
        if (strcasecmp($file_extension, 'jpg') === 0 || strcasecmp($file_extension, 'png') === 0 || strcasecmp($file_extension, 'jepg') === 0) {
            $name = Str::random(5) . "-" . $file_name;
            while (file::exists($upload_dir . $name)) {
                $name = Str::random(5) . "-" . $file_name;
            }
            $path = $file->move($upload_dir, $name);
            if ($path) {
                return $path;
            }
            return false;
        }
    }

    public function uploadImage2($file)
    {
        $file = $file;
        $upload_dir =  Constants::PATH_IMAGE . "product/main/";
        $file_name = $file->getClientOriginalName();
        $file_extension = $file->getClientOriginalExtension();
        if (strcasecmp($file_extension, 'jpg') === 0 || strcasecmp($file_extension, 'png') === 0 || strcasecmp($file_extension, 'jepg') === 0) {
            $name = Str::random(5) . "-" . $file_name;
            while (file::exists($upload_dir . $name)) {
                $name = Str::random(5) . "-" . $file_name;
            }
            $path = $file->move($upload_dir, $name);
            if ($path) {
                return $path;
            }
            return false;
        }
    }

    public function uploadMultipleImage($file, $folder, $id)
    {
        $file = $file;
        $path = [];
        $upload_dir = Constants::PATH_IMAGE . "$folder/$id/";
        foreach ($file as $item) {
            $file_name = $item->getClientOriginalName();
            $file_extension = $item->getClientOriginalExtension();
            if (strcasecmp($file_extension, 'jpg') === 0 || strcasecmp($file_extension, 'png') === 0 || strcasecmp($file_extension, 'jepg') === 0) {
                $name = Str::random(5) . "-" . $file_name;
                while (file::exists($upload_dir . $name)) {
                    $name = Str::random(5) . "-" . $file_name;
                }
                $path[] = $item->move($upload_dir, $name);
            }
        }
        return $path;
    }

    public function deleteImage($file)
    {
        if (file::exists($file))
            file::delete($file);
        return false;
    }
}
