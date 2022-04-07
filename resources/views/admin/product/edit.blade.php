@extends('layouts.admin')
@section('title', 'Cập nhập sản phẩm')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-head d-flex mt-3">
            <div class="card-title  font-weight-bold mr-3 ml-3">
                <h3>Sửa sản phẩm</h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.update',$product->id) }}" method='POST' enctype='multipart/form-data'>
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="product_name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="product_name" id="product_name"
                                value="{{ $product->product_name }}">
                            @error('product_name') <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="intro">Mô tả sản phẩm</label>
                            <textarea name="product_desc" class="form-control" id="intro" cols="30"
                                rows="5">{{ $product->product_desc }}</textarea>
                            @error('product_desc')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="intro">Chi tiết sản phẩm</label>
                            <textarea name="product_content" class="form-control" id="intro" cols="30"
                                rows="5">{{ $product->product_content }}</textarea>
                            @error('product_content')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Ảnh bài viết</label>
                            <input id="img" type="file" name="product_thumb" class="form-control d-none"
                                onchange="changeImg(this)">
                            <img id="avatar" class="img-thumbnail d-block" width="200px"
                                src="{{ asset($product->product_thumb) }}">
                            @error('product_thumb')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục sản phẩm</label>
                            <select class="form-control" id="" name="category_product">
                                <option value="0">Danh mục cha</option>
                                @foreach ($data_category_product as $key => $val)
                                @if($key == $product->product_cat_id)
                                <option selected value="{{ $key }}">{{ $val }}</option>
                                @else
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('category_product')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Thương hiệu sản phẩm</label>
                            <select class="form-control" id="" name="brand">
                                <option value="0">Danh mục cha</option>
                                @foreach ($data_brand as $key => $val)
                                @if($key == $product->brand_id)
                                <option selected value="{{ $key }}">{{ $val }}</option>
                                @else
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('brand')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" name="btn_update" class="btn btn-primary">Cập nhập</button>
            </form>
        </div>
    </div>
</div>
@endsection
