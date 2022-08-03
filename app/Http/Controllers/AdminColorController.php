<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use Illuminate\Http\Request;
use App\Repositories\Color\ColorRepositoryInterface;
use Illuminate\Support\Str;


class AdminColorController extends Controller
{
    protected $colorRepo;
    public function __construct(ColorRepositoryInterface $colorRepo)
    {
        $this->colorRepo = $colorRepo;
    }

    public function list()
    {
        $list_act = ['delete' => 'Xóa'];
        $list_colors = $this->colorRepo->get_list_color();
        return view('admin.color.list', compact('list_colors', 'list_act'));
    }

    public function add(Request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'color_name' => 'required|max:100|unique:colors',
                    'code_color' => 'required|max:100|unique:colors'
                ],
            );
            $data = [
                'color_name' => $request->input('color_name'),
                'code_color' => $request->input('code_color'),
                'slug' => Str::slug($request->input('color_name')),
                "created_at" =>  now(),
                "updated_at" => now(),
            ];

            $this->colorRepo->add($data);
            return back()->with('status', trans('notification.add_success'));
        }
    }

    public function edit($id)
    {
        if ($id != null) {
            $color = $this->colorRepo->get_color_by_id($id, ['id', 'color_name', 'code_color']);
            return view('admin.color.edit', compact('color'));
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->has('btn_update')) {
            $request->validate(
                [
                    'color_name' => 'required|max:100|unique:colors,color_name,' . $id . ',id',
                    'code_color' => 'required|max:100|unique:colors,code_color,' . $id . ',id'
                ],
            );
            $data = [
                'color_name' => $request->input('color_name'),
                'code_color' => $request->input('code_color'),
                'slug' => Str::slug($request->input('color_name')),
                "created_at" =>  now(),
                "updated_at" => now(),
            ];

            $this->colorRepo->update($data, $id);
            return redirect()->route('admin.color.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if ($id != null) {

            $this->colorRepo->forceDelete($id);
            return redirect()->route('admin.color.list')->with('status', trans('notification.delete_success'));
        }
    }

    public function action(Request $request)
    {
        if ($request->has('btn_action')) {
            $list_check = $request->input('list_check');
            if ($list_check != null) {
                $act = $request->input('act');
                if ($act == Constants::DELETE) {
                    $this->colorRepo->forceDelete($list_check);
                    return redirect()->route('admin.color.list');
                }
            }
        }
    }
}
