@extends('layouts.admin')
@section('title','Thay đổi mật khẩu')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-header font-weight-bold">
            Thay đổi mật khẩu
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user.changePassUpdate',$user->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="password">Mật khẩu mới</label>
                    <input class="form-control" type="password" name="password" id="password" value="">
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">Nhập lại mật khẩu</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
                </div>
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
                <button type="submit" class="btn btn-primary" name="btn_update_pass_profile">Cập nhập mật khẩu</button>
            </form>
        </div>
    </div>
</div>
@endsection