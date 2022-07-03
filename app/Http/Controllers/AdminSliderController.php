<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\Constants;
use Illuminate\Support\Str;
use App\Models\Slider;
use App\Helpers\ImageUpload;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class AdminSliderController extends Controller
{
    use ImageUpload;
    public function list(Request $request)
    {
        $status = $request->input('status');
        if (!$status || $status == 'on') {
            $list_sliders = Slider::where('slider_status', 'on')->paginate(20);
        } else {
            $list_sliders = Slider::where('slider_status', 'off')->paginate(20);
        }

        return view('admin.slider.list', compact('list_sliders'));
    }

    public function add(Request $request)
    {
        if ($request->has('slider_add')) {
            $request->validate(
                [
                    'image' => 'required',
                    'slider_status' => 'required',
                ],
            );

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $request->image->extension();
                $filename = time() . "." . $extension;
                $image = Image::make($file->getRealPath())->fit(1263, 710)->save(storage_path('app/public/images/slider/' . $filename));
            }

            $data = [
                'slider_path' => 'storage/app/public/images/slider/' . $filename,
                'slider_status' => $request->input('slider_status'),
                "created_at" =>  now(),
                "updated_at" => now(),
            ];

            Slider::create($data);
            return back()->with('status', trans('notification.add_success'));
        }
    }

    public function edit($id)
    {
        if ($id != null) {
            $slider = Slider::find($id);
            return view('admin.slider.edit', compact('slider'));
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->has('slider_update')) {
            $request->validate(
                [
                    'slider_status' => 'required',
                ],
            );
            $data = [
                'slider_status' => $request->input('slider_status'),
                "updated_at" => now(),
            ];

            Slider::find($id)->update($data);
            return redirect()->route('admin.slider.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if ($id != null) {
            Slider::find($id)->delete();
            return redirect()->route('admin.slider.list')->with('status', trans('notification.force_delete_success'));
        }
    }
}
