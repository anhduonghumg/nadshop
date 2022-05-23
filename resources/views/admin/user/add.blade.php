@extends('layouts.admin')
@section('title','Thêm người quản trị')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm người dùng
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="fullname">Họ và tên</label>
                    <input class="form-control" type="text" name="fullname" id="fullname">
                    @error('fullname')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="username">Tên người dùng</label>
                    <input class="form-control" type="text" name="username" id="username">
                    @error('username')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input class="form-control" type="text" name="phone" id="phone">
                    @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email">
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" id="password">
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">Nhập lại mật khẩu</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
                </div>

                <div class="form-group">
                    <label for="">Nhóm quyền</label>
                    <select class="form-control" name='role_permission' id='role'>
                        <option value="">Chọn quyền</option>
                        @foreach ($list_roles as $role)
                        <option value="{{ $role->id}}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                    @error('role_permission')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" name="btn_add">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
