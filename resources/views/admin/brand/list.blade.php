@extends('layouts.admin')
@section('title','Thương hiệu')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm thương hiệu
                </div>
                <div class="card-body">
                    <form action="{{route('admin.brand.add')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="brand_name">Tên thương hiệu</label>
                            <input class="form-control" type="text" name="brand_name" id="brand_name">
                            @error('brand_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="pending" value="pending"
                                    checked>
                                <label class="form-check-label" for="pending">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="public" value="public">
                                <label class="form-check-label" for="public">
                                    Công khai
                                </label>
                            </div>
                        </div>
                        <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách thương hiệu
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích
                            hoạt<span class="text-muted">({{ $count[0] }}) |</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted">({{ $count[2] }}) |</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                            hóa<span class="text-muted">({{ $count[1] }})</span></a>
                    </div>
                    <form action="{{ route('admin.brand.action') }}" method="POST">
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
                                        <input name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Ngày tạo</th>
                                    @if (request()->input('status') == 'trash')
                                    <th scope="col">Ngày xóa</th>
                                    @else
                                    <th scope="col">Trạng thái</th>
                                    @endif
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($list_brands->total() > 0)
                                @php
                                $t = 1;
                                @endphp
                                @foreach ($list_brands as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                    </td>
                                    <th scope="row">{{ $t++ }}</th>
                                    <td scope>{{ $item->brand_name }}</td>
                                    <td>{{ $item->fullname }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    @if(request()->input('status') == Constants::TRASH)
                                    <td>{{ $item->deleted_at }}</td>
                                    @elseif ($item->status == 'public')
                                    <td>Công khai</td>
                                    @else
                                    <td>Chờ duyệt</td>
                                    @endif
                                    @if (request()->input('status') == Constants::TRASH)
                                    <td>
                                        <a href="{{ route('admin.brand.edit', ['id' => $item->id]) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.brand.forceDelete', ['id' => $item->id]) }}"
                                            onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                    @else
                                    <td>
                                        <a href="{{ route('admin.brand.edit', ['id' => $item->id]) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.brand.delete', ['id' => $item->id]) }}"
                                            onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                            data-url="{{ route('admin.brand.delete', ['id' => $item->id]) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan='7' class="bg-white">
                                        <p>Không có bản ghi nào.</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </form>
                    {{ $list_brands->links('layouts.paginationlink') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
