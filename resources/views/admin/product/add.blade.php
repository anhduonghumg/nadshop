@extends('layouts.admin')
@section('title', 'Thêm sản phẩm')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-head d-flex mt-3">
            <div class="card-title  font-weight-bold mr-3 ml-3">
                <h3>Thêm sản phẩm</h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.store') }}" method='POST' enctype='multipart/form-data'>
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="product_name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="product_name" id="product_name">
                            @error('product_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="cost_price">Giá nhập sản phẩm</label>
                            <input class="form-control" type="text" name="cost_price" id="cost_price">
                            @error('cost_price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sell_price">Giá bán sản phẩm</label>
                            <input class="form-control" type="text" name="sell_price" id="sell_price">
                            @error('sell_price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sale">Giảm giá</label>
                            <input class="form-control" type="text" name="sale" id="sale">
                            @error('sale')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label for="intro">Mô tả sản phẩm</label>
                            <textarea name="product_desc" class="form-control" id="intro" cols="30" rows="5"></textarea>
                            @error('product_desc')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="intro">Chi tiết sản phẩm</label>
                            <textarea name="product_content" class="form-control" id="intro" cols="30"
                                rows="5"></textarea>
                            @error('product_content')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Ảnh đại diện sản phẩm</label>
                            <input id="img" type="file" name="product_thumb" class="form-control d-none"
                                onchange="changeImg(this)">
                            <img id="avatar" class="img-thumbnail d-block" width="200px"
                                src="{{ asset('storage/app/public/images/upload_img.png') }}">
                            @error('product_thumb')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Ảnh chi tiết sản phẩm</label>
                            <input class="form-control" type="file" id="images" name="list_product_thumb[]" multiple>
                            @error('list_product_thumb')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục sản phẩm</label>
                            <select class="form-control" id="" name="category_product">
                                <option value="">Chọn danh mục</option>
                                @foreach ($data_category_product as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            @error('category_product')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Thương hiệu sản phẩm</label>
                            <select class="form-control" id="" name="brand">
                                <option value="">Chọn thương hiệu</option>
                                @foreach ($data_brand as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            @error('brand')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="product_new" id="product_new" value=1>
                            <label for="product_new">Sản phẩm mới</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="product_best_seller" id="product_best_seller" value=1>
                            <label for="product_best_seller">Sản phẩm bán chạy</label>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_status" id="pending"
                                    value="pending" checked>
                                <label class="form-check-label" for="pending">
                                    Không hoạt động
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_status" id="public"
                                    value="public">
                                <label class="form-check-label" for="public">
                                    Hoạt động
                                </label>
                            </div>
                            @error('product_status')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
