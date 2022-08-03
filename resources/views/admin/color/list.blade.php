@extends('layouts.admin')
@section('title','Màu')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm màu sản phẩm
                </div>
                <div class="card-body">
                    <form action="{{route('admin.color.add')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="color_name">Tên màu</label>
                            <input class="form-control" type="text" name="color_name" id="color_name">
                            @error('color_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="code_color">Mã màu</label>
                            <input class="form-control" type="text" name="code_color" id="code_color">
                            @error('code_color')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách màu
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    {{-- <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích
                            hoạt<span class="text-muted">({{ $count[0] }}) |</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted">({{ $count[2] }}) |</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                            hóa<span class="text-muted">({{ $count[1] }})</span></a>
                    </div> --}}
                    <form action="{{ route('admin.color.action') }}" method="POST">
                        @csrf
                        <div class="form-action form-inline py-3">
                            <select class="form-control mr-1" name="act" id="">
                                <option>Chọn</option>
                                @foreach ($list_act as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>
                            <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary">
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input id="checkall" name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($list_colors->total() > 0)
                                @php
                                $t = 1;
                                @endphp
                                @foreach ($list_colors as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                    </td>
                                    <th scope="row">{{ $t++ }}</th>
                                    <td scope>{{ $item->color_name }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.color.edit', ['id' => $item->id]) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.color.delete', ['id' => $item->id]) }}"
                                            onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                            data-url="{{ route('admin.color.delete', ['id' => $item->id]) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
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
                    {{ $list_colors->links('layouts.paginationlink') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
