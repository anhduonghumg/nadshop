<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function resize()
    {
        $image = Image::make('storage/app/public/images/test/test.jpg');
        $image->fit(600, 600)->save('storage/app/public/images/testLarge.jpg');
        $image->fit(400, 400)->save('storage/app/public/images/testMedium.jpg');
        $image->fit(150, 150)->save('storage/app/public/images/testtThumbnail.jpg');

        return 'Done';
    }


    public function flyResize($size, $imagePath)
    {
        $imageFullPath = base_path($imagePath);
        $image_extension = Str::afterLast($imagePath, '/');
        $sizes = config('image.sizes');

        if (!file_exists($imageFullPath) || !isset($sizes[$size])) {
            abort(404);
        }

        $savedPath = base_path(Constants::PATH_IMAGE . $size . "/" . $image_extension);
        $savedDir = dirname($savedPath);
        if (!is_dir($savedDir)) {
            mkdir($savedDir, 777, true);
        }
        list($width, $height) = $sizes[$size];
        $image = Image::make($imageFullPath)->fit($width, $height)->save($savedPath);

        return $image->response();
    }

    public function upload()
    {
        return view('fileTest.upload');
    }
}
