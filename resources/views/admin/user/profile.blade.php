@extends('layouts.admin')
@section('title','Cập nhập thông tin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thông Tin Tài Khoản
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user.profileUpdate',$user->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="username">Tên tài khoản</label>
                    <input class="form-control" type="text" name="username" id="username" value="{{ $user->username }}"
                        disabled>
                    @error('username')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}" disabled>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
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
                    <label for="created_at">Ngày gia nhập</label>
                    <input class="form-control" type="text" name="created_at" id="created_at"
                        value="{{ $user->created_at }}" disabled>
                    @error('created_at')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label for="password">Mật khẩu mới</label>
                    <input class="form-control" type="password" name="password" id="password" value="">
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">Nhập lại mật khẩu</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
                </div> --}}
                {{-- <div class="form-group">
                    <label for="">Nhóm quyền</label>
                    <select class="form-control" id="">
                        <option>Chọn quyền</option>
                        <option>Danh mục 1</option>
                        <option>Danh mục 2</option>
                        <option>Danh mục 3</option>
                        <option>Danh mục 4</option>
                    </select>
                </div> --}}
                <button type="submit" class="btn btn-primary" name="btn_update_profile">Cập nhập</button>
            </form>
        </div>
    </div>
</div>
@endsection