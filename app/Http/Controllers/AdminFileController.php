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
        $validated = $request->validate([
            // 'title' => 'required',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $image_names = [];
        // loop through images and save to /uploads directory
        // foreach ($request->file('images') as $image) {
        //     $name = $image->getClientOriginalName();
        //     $image->move(public_path() . '/uploads/', $name);
        //     $image_names[] = $name;
        // }

        // $post = new Post();
        // $post->title = $request->title;
        // $post->images = json_encode($image_names);

        // $post->save();

        // return redirect()
        //     ->back()
        //     ->with('success', 'Post created successfully.');
    }


    public function multiple()
    {
        return view('fileTest.preUpload');
    }
}
