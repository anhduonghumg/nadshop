@extends('layouts.admin')
@section('title', 'Thêm sản phẩm')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-head d-flex mt-3">
            <div class="card-title  font-weight-bold mr-3 ml-3">
                <h3>Thêm sản phẩm</h3>
            </div>
            {{-- <div class="btn-add-detail-roduct">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Thêm sản phẩm chi tiết
                </button>
                <div class="modal fade draggable" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg ui-draggable" role="document">
                        <div class="modal-content p-3">
                            <form action="" method="POST">
                                <div class="modal-header ui-dranggale-handle" style="cursor: move;">
                                    <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết sản phẩm</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <ul class="nav nav-tabs mt-3 mb-3" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="p_1-tab" data-toggle="tab" href="#p_1" role="tab"
                                            aria-selected="true">Product</a>
                                        <span class="remove-product-tab"><i class="fa fa-times" aria-hidden="true"></i>
                                        </span>
                                    <li class="nav-item"><a class="nav-link" href="#" id="add_work"><i
                                                class="fa fa-plus" aria-hidden="true"></i></a></li>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="p_1" role="tabpanel"
                                        aria-labelledby="p_1-tab">
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group row">
                                                    <label for="product_name" class="col-sm-4 control-label">Tên sản
                                                        phẩm:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="product_name"
                                                            placeholder="Tên sản phẩm" name="product_name[]">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="product_type"
                                                        class="col-sm-4 control-label">Loại:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="product_type"
                                                            placeholder="Loại sản phẩm" name="product_type[]">
                                                    </div>
                                                </div>

                                                <div class="form-group row ">
                                                    <label for="product_price"
                                                        class="col-sm-4 control-label">Giá:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="product_price"
                                                            placeholder="Giá sản phẩm (VNĐ)" name="product_price[]">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="product_discount" class="col-sm-4 control-label">Khuyến
                                                        mãi:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="product_discount"
                                                            placeholder="Khuyến mãi (%)" name="product_discount[]">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="stock" class="col-sm-4 control-label">Số lượng:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="stock"
                                                            placeholder="Số lượng sản phẩm" name="stock[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group row">
                                                    <label for="color" class="col-sm-4 control-label">Màu:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="color" name="color[]">
                                                            <option selected>Chọn màu</option>
                                                            <option>Xanh</option>
                                                            <option>Đỏ</option>
                                                            <option>Tím</option>
                                                            <option>Vàng</option>
                                                            <option>Hồng</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="size_ver" class="col-sm-4 control-label">Kích
                                                        cỡ/bản:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="size_ver" name="size_ver[]">
                                                            <option selected>Chọn kích cỡ/phiên bản</option>
                                                            <option>S</option>
                                                            <option>M</option>
                                                            <option>L</option>
                                                            <option>16GB</option>
                                                            <option>32GB</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row ">
                                                    <label for="" class="col-sm-4 control-label">Ảnh:</label>
                                                    <div class="col-sm-8">
                                                        <input id="img" type="file" name="thumbnail[]"
                                                            class="form-control d-none" onchange="changeImg(this)">
                                                        <img id="avatar" class="img-thumbnail d-block" width="300px"
                                                            src="{{ asset('storage/app/public/images/upload_img.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}
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
                            <label for="">Ảnh bài viết</label>
                            <input id="img" type="file" name="thumbnail" class="form-control d-none"
                                onchange="changeImg(this)">
                            <img id="avatar" class="img-thumbnail d-block" width="200px"
                                src="{{ asset('storage/app/public/images/upload_img.png') }}">
                            @error('thumbnail')
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
                        </div>
                        <div class="form-group">
                            <label for="">Thương hiệu sản phẩm</label>
                            <select class="form-control" id="" name="brand">
                                <option value="">Chọn danh mục</option>
                                @foreach ($data_brand as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
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

                <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
