<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Helpers\ImageUpload;


class AdminFileController extends Controller
{
    use ImageUpload;

    public function view()
    {
        return view('testFile');
    }

    public function upload(Request $request)
    {
        if ($request->has('btn_upload')) {
            $request->validate(
                [
                    'photo' => ['required', 'image', 'mimes:jpeg,png,jpg']
                ]
            );

            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $folder = "test";
                $id = 5;
                $upload = $this->uploadImage($file, $folder, $id);
            }
            return $upload;
        }
    }

    public function multipleUpload(Request $request)
    {
        if ($request->has('btn_upload')) {
            $request->validate(
                [
                    'image' => ['required']
                ]
            );

            if ($request->hasFile('image')) {
                foreach ($request->image as $item) {
                    dd($item);
                }
            }
            // return $upload;
        }
    }


    public function multiple()
    {
        return view('fileTest.preUpload');
    }
}
