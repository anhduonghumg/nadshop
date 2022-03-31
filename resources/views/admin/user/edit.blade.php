@extends('layouts.admin')
@section('title','Thêm người quản trị')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm người dùng
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user.update',$user->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="fullname">Họ và tên</label>
                    <input class="form-control" type="text" name="fullname" id="fullname" value="{{ $user->fullname }}">
                    @error('fullname')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="username">Tên tài khoản</label>
                    <input class="form-control" type="text" name="username" id="username" value="{{ $user->username }}"
                        disabled>
                    @error('username')
                    {{-- <small class="text-danger">{{ $message }}</small> --}}
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}" disabled>
                    @error('email')
                    {{-- <small class="text-danger">{{ $message }}</small> --}}
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input class="form-control" type="text" name="phone" id="phone" value="{{ $user->phone }}">
                    @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" id="password"
                        value="{{ $user->password }}" disabled>
                    @error('password')
                    {{-- <small class="text-danger">{{ $message }}</small> --}}
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label for="password-confirm">Nhập lại mật khẩu</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
                </div> --}}
                <div class="form-group">
                    <label for="">Nhóm quyền</label>
                    <select class="form-control" id="">
                        <option>Chọn quyền</option>
                        <option>Danh mục 1</option>
                        <option>Danh mục 2</option>
                        <option>Danh mục 3</option>
                        <option>Danh mục 4</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="btn_update">Cập nhập</button>
            </form>
        </div>
    </div>
</div>
@endsection
