@extends('layouts.admin')
@section('title', 'Thêm trang')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm Trang
            </div>
            <div class="card-body">
                <form action="{{ url('admin/page/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề trang</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung trang</label>
                        <textarea name="content" class="form-control content" id="content" cols="30"
                            rows="8">{{ request()->old('content') }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- <button type="button" name="add" id="add" class="btn btn-success btn-xs d-block float-right">+</button> --}}
                    <button type="submit" name="btn_add" class="btn btn-primary" value="btn_add">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
