@extends('layouts.admin')
@section('title', 'Danh sách người dùng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách thành viên</h5>
            <div class="form-search form-inline">
                <form action="" method="GET">
                    <input type="text" class="form-control form-search" name="keyword"
                        value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                {{-- <a href="" class="text-primary">Tất cả<span class="text-muted">(10) |</span></a> --}}
                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích
                    hoạt<span class="text-muted">({{ $count[0] }}) |</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                    hóa<span class="text-muted">({{ $count[1] }})</span></a>
            </div>
            <form action="{{ url('admin/user/action') }}" method="POST">
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
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input id="checkall" name="checkall" type="checkbox">
                            </th>
                            <th scope="col">STT</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col">Xác thực tài khoản</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isNotEmpty())
                        @php
                        $temp=0;
                        @endphp
                        @foreach ($users as $user)
                        @php
                        $temp++;
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{ $user->id }}">
                            </td>
                            <th scope="row">{{ $temp }}</th>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->email }}</td>
                            @if ($user->role_id == 1)
                            <td>Người dùng</td>
                            @else
                            <td>Quản trị</td>
                            @endif
                            @if ($user->email_verified_at != null)
                            <td>Đã xác thực</td>
                            @else
                            <td>Chưa xác thực</td>
                            @endif
                            {{-- <td>{{ $user->email_verified_at }}</td> --}}
                            <td>{{ $user->created_at }}</td>
                            @if(request()->status != 'trash')
                            <td>
                                <a href="{{ route('admin.user.edit',$user->id) }}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                @if(Auth::id() != $user->id)
                                <a href="{{ route('admin.user.delete',$user->id) }}"
                                    onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
                                @endif
                            </td>
                            @else
                            <td>
                                {{-- <a href="{{ route('admin.user.edit',$user->id) }}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a> --}}
                                <a href="{{ route('admin.user.forceDelete',$user->id) }}"
                                    onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan='6' class="bg-white">
                                <p>Không có bản ghi nào.</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </form>
            {{ $users->links('layouts.paginationlink') }}
        </div>
    </div>
    @endsection
