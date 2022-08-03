@extends('layouts.admin')
@section('title', 'Sửa bài viết')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Sửa bài viết
            </div>
            <div class="card-body">
                <form action="{{ route('admin.post.update', $id) }}" method='POST' enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label for="title">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="title" id="title"
                            value="{{ $post->title }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả bài viết</label>
                        <textarea name="desc" class="form-control tinytextarea" id="desc" cols="30" rows="5">{{ $post->desc }}</textarea>
                        @error('desc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea name="content" class="form-control tinytextarea" id="content" cols="30" rows="5">{{ $post->content }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Ảnh bài viết</label>
                        <input id="img" type="file" name="thumbnail" class="form-control d-none"
                            onchange="changeImg(this)">
                        <img id="avatar" class="img-thumbnail d-block" width="200px"
                            src="{{ asset($post->thumbnail) }}">
                        @error('thumbnail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Danh mục</label>
                        <select class="form-control" id="" name="category_post">
                            <option value="0">Danh mục cha</option>
                            @foreach ($data_cat_post as $key => $val)
                                @if ($key == $post->post_cat_id)
                                    <option selected value="{{ $key }}">{{ $val }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $val }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('category_post')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" name='btn_update' class="btn btn-primary">Cập nhập</button>
                </form>
            </div>
        </div>
    </div>
@endsection
