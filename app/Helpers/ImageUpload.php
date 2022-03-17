<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
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
}
