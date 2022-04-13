<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageUpload
{
    public function ImageUpload($file, $folderName)
    {
        $fileNameOriginal = $file->getClientOriginalName();
        $filePath = $file->move('storage/app/public/images/' . $folderName . '/' . Auth::id(), $fileNameOriginal);

        $dataUpload = [
            'file_name' => $fileNameOriginal,
            'file_path' => $filePath
        ];
        return $dataUpload;
    }

    public function uploadImage($file, $folder, $id)
    {
        $file = $file;
        $upload_dir = "storage/app/public/images/$folder/$id/";
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
}
