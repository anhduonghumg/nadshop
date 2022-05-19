<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repositories\Size\SizeRepositoryInterface;

class AdminSizeController extends Controller
{
    protected $sizeRepo;
    public function __construct(sizeRepositoryInterface $sizeRepo)
    {
        $this->sizeRepo = $sizeRepo;
    }

    public function list()
    {
        $list_act = ['delete' => 'Xóa'];
        $list_sizes = $this->sizeRepo->get_list_size();
        return view('admin.size.list', compact('list_sizes', 'list_act'));
    }

    public function add(Request $request)
    {
        if ($request->has('btn_add')) {
            $request->validate(
                [
                    'size_name' => 'required|max:100|unique:sizes',
                ],
            );
            $data = [
                'size_name' => $request->input('size_name'),
                'slug' => Str::slug($request->input('size_name')),
                "created_at" =>  now(),
                "updated_at" => now(),
            ];

            $this->sizeRepo->add($data);
            return back()->with('status', trans('notification.add_success'));
        }
    }

    public function edit($id)
    {
        if ($id != null) {
            $size = $this->sizeRepo->get_size_by_id($id, ['id', 'size_name']);
            return view('admin.size.edit', compact('size'));
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->has('btn_update')) {
            $request->validate(
                [
                    'size_name' => 'required|max:100|unique:sizes,size_name,' . $id . ',id'
                ],
            );
            $data = [
                'size_name' => $request->input('size_name'),
                'slug' => Str::slug($request->input('size_name')),
                "created_at" =>  now(),
                "updated_at" => now(),
            ];

            $this->sizeRepo->update($data, $id);
            return redirect()->route('admin.size.list')->with('status', trans('notification.update_success'));
        }
    }

    public function delete($id)
    {
        if ($id != null) {

            $this->sizeRepo->forceDelete($id);
            return redirect()->route('admin.size.list')->with('status', trans('notification.delete_success'));
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
