@extends('layouts.admin')
@section('title', 'Coupon')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm mã giảm giá
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.coupon.add') }}" method="POST" enctype='multipart/form-data'>
                            @csrf
                            <div class="form-group">
                                <label for="code">Mã giảm giá</label>
                                <input class="form-control" type="text" name="code" id="code">
                                @error('code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="value">Giá trị</label>
                                <input class="form-control" type="text" name="value" id="value">
                                @error('value')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="qty">Số lượng</label>
                                <input class="form-control" type="number" name="qty" id="qty" min="1">
                                @error('qty')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="on"
                                        value="on" checked>
                                    <label class="form-check-label" for="on">
                                        Hoạt động
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="off"
                                        value="off">
                                    <label class="form-check-label" for="off">
                                        Không hoạt động
                                    </label>
                                </div>
                                @error('status')
                                    <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" name="coupon_add" class="btn btn-primary">Thêm mới</button>
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
                        <form action="{{ route('admin.coupon.action') }}" method="POST">
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
                                        <th scope="col">Mã giảm giá</th>
                                        <th scope="col">Giá trị</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($list_coupons->total() > 0)
                                        @php
                                            $t = 1;
                                        @endphp
                                        @foreach ($list_coupons as $item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                                </td>
                                                <th scope="row">{{ $t++ }}</th>
                                                <td>{{ $item->code }}</td>
                                                </td>
                                                <td>{{ currentcyFormat($item->value) }}</td>
                                                <td>{{ $item->qty }}</td>
                                                </td>
                                                @if ($item->status == 'on')
                                                    <td scope>Hoạt động</td>
                                                @else
                                                    <td>Không hoạt động</td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('admin.coupon.edit', ['id' => $item->id]) }}"
                                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a href="{{ route('admin.coupon.delete', ['id' => $item->id]) }}"
                                                        onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                                        data-url="{{ route('admin.coupon.delete', ['id' => $item->id]) }}"
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
                        {{ $list_coupons->links('layouts.paginationlink') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
