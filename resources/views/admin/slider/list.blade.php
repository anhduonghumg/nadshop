@extends('layouts.admin')
@section('title', 'Slider')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm Slider
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.slider.add') }}" method="POST" enctype='multipart/form-data'>
                            @csrf
                            <div class="form-group">
                                <label for="image">Chọn slider</label>
                                <input class="form-control" type="file" name="image" id="image">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="slider_status" id="on"
                                        value="on" checked>
                                    <label class="form-check-label" for="on">
                                        Hoạt động
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="slider_status" id="off"
                                        value="off">
                                    <label class="form-check-label" for="off">
                                        Không hoạt động
                                    </label>
                                </div>
                                @error('slider_status')
                                    <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" name="slider_add" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách slider
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="analytic">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'on']) }}" class="text-primary">Hoạt
                                động<span class="text-muted"> |</span></a>
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'off']) }}" class="text-primary">Không
                                hoạt động<span class="text-muted"></span></a>
                        </div>
                        <form action="{{ route('admin.slider.action') }}" method="POST">
                            @csrf
                            {{-- <div class="form-action form-inline py-3">
                                <select class="form-control mr-1" name="act" id="">
                                    <option>Chọn</option>
                                    @foreach ($list_act as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                                <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary">
                            </div> --}}
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input id="checkall" name="checkall" type="checkbox">
                                        </th>
                                        <th scope="col">STT</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($list_sliders->total() > 0)
                                        @php
                                            $t = 1;
                                        @endphp
                                        @foreach ($list_sliders as $item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                                </td>
                                                <th scope="row">{{ $t++ }}</th>
                                                <td scope>
                                                    <img src="{{ asset($item->slider_path) }}" width="80px"
                                                        height="50px"alt="">
                                                </td>
                                                @if ($item->slider_status == 'on')
                                                    <td scope>Hoạt động</td>
                                                @else
                                                    <td>Không hoạt động</td>
                                                @endif
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    <a href="{{ route('admin.slider.edit', ['id' => $item->id]) }}"
                                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a href="{{ route('admin.slider.delete', ['id' => $item->id]) }}"
                                                        onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                                        data-url="{{ route('admin.size.delete', ['id' => $item->id]) }}"
                                                        class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                                        type="button" data-toggle="tooltip" data-placement="top"
                                                        title="Delete"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan='5' class="bg-white">
                                                <p>Không có bản ghi nào.</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </form>
                        {{ $list_sliders->links('layouts.paginationlink') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
