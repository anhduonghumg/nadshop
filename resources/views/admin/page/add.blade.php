@extends('layouts.admin')
@section('title','Thêm trang')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm trang
        </div>
        <div class="card-body">
            <form action="{{ url('admin/page/store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên trang</label>
                    <input class="form-control" type="text" name="name" id="name">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="desc">Mô tả</label>
                    <textarea name="desc" class="form-control" id="desc" cols="30" rows="5"></textarea>
                    @error('desc')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung trang</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5"></textarea>
                    @error('content')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="pending" value="pending" checked>
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
                <button type="submit" class="btn btn-primary" name="btn_add">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection