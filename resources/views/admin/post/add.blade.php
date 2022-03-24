@extends('layouts.admin')
@section('title','Thêm bài viết')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form action="{{ url('admin/post/store') }}" method='POST' enctype='multipart/form-data'>
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="title">
                    @error('title')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="desc">Mô tả bài viết</label>
                    <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">{{ old('desc') }}</textarea>
                    @error('desc')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30"
                        rows="5">{{ old('content') }}</textarea>
                    @error('content')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="thumbnail">Ảnh bài viết</label>
                    <input id="img" type="file" name="thumbnail" class="form-control d-none" onchange="changeImg(this)">
                    <img id="avatar" class="img-thumbnail d-block" width="200px"
                        src="{{ asset('storage/app/public/images/upload_img.png') }}">
                    @error('thumbnail')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" id="" name="category_post">
                        <option value="">Chọn danh mục</option>
                        @foreach ($data_category_post as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('category_post')
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
                <button type="submit" name='btn_add' class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
