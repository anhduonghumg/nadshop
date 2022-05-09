@extends('layouts.admin')
@section('title', 'Cập nhập trang')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập Nhập Trang
        </div>
        <div class="card-body">
            <form action="{{ url("admin/page/update/$page->id") }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="page_name">Tiêu đề trang</label>
                    <input class="form-control" type="text" name="page_name" id="page_name"
                        value="{{ $page->page_name }}">
                    @error('page_name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="desc">Mô tả</label>
                    <textarea name="desc" class="form-control tinytextarea" id="desc" cols="30" rows="5">{{ $page->desc }}</textarea>
                    @error('desc')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung trang</label>
                    <textarea name="content" class="form-control content tinytextarea" id="content" cols="30"
                        rows="8">{{ $page->content }}</textarea>
                    @error('content')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" name="btn_update" class="btn btn-primary" value="btn_update">Cập nhập</button>
            </form>
        </div>
    </div>
</div>
@endsection
