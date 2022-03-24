@extends('layouts.admin')
@section('title','Thêm sản phẩm')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>

                        <div class="form-group">
                            <label for="intro">Mô tả sản phẩm</label>
                            <textarea name="" class="form-control" id="intro" cols="30" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="intro">Chi tiết sản phẩm</label>
                            <textarea name="" class="form-control" id="intro" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Ảnh bài viết</label>
                            <input type="file" name="thumbnail" class="form-control" id="thumbnail">
                            {{-- <input id="img" type="file" name="thumbnail" class="form-control d-none">
                            <img id="avatar" class="img-thumbnail d-block" width="200px"
                                src="{{ asset('storage/app/public/images/upload_img.png') }}"> --}}
                            {{-- @error('thumbnail')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror --}}
                        </div>

                        <div class="form-group">
                            <label for="">Danh mục sản phẩm</label>
                            <select class="form-control" id="">
                                <option>Chọn danh mục</option>
                                <option>Danh mục 1</option>
                                <option>Danh mục 2</option>
                                <option>Danh mục 3</option>
                                <option>Danh mục 4</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Thương hiệu sản phẩm</label>
                            <select class="form-control" id="">
                                <option>Chọn danh mục sản phẩm</option>
                                <option>Danh mục 1</option>
                                <option>Danh mục 2</option>
                                <option>Danh mục 3</option>
                                <option>Danh mục 4</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                    value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                                    value="option2">
                                <label class="form-check-label" for="exampleRadios2">
                                    Công khai
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
