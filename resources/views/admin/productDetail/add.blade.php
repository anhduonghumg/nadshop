@extends('layouts.admin')
@section('title', 'Thêm sản phẩm')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-head d-flex mt-3">
            <div class="card-title  font-weight-bold mr-3 ml-3">
                <h3>Thêm sản phẩm chi tiết</h3>
            </div>
        </div>
        <div class="card-body">
            <form action="route('admin.product.detail.store')" method='POST' enctype='multipart/form-data'>
                @csrf
                <div class="modal-header ui-dranggale-handle" style="cursor: move;">
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
                    <li class="nav-item"><a class="nav-link" href="#" id="add_work"><i class="fa fa-plus"
                                aria-hidden="true"></i></a></li>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="p_1" role="tabpanel" aria-labelledby="p_1-tab">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 control-label">Tên sản
                                        phẩm:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="product_name"
                                            placeholder="Tên sản phẩm" name="product_detail_name[]">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label for="product_price" class="col-sm-4 control-label">Giá:</label>
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
                                    <label for="stock" class="col-sm-4 control-label">Số
                                        lượng:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="stock"
                                            placeholder="Số lượng sản phẩm" name="product_qty_stock[]">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="color" class="col-sm-4 control-label">Màu:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="color" name="product_color[]">
                                            <option selected>Chọn màu</option>
                                            @foreach ($list_product_color as $item)
                                            <option value="{{ $item->id }}">{{ $item->color_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="size_ver" class="col-sm-4 control-label">Kích
                                        cỡ/bản:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="size_ver" name="product_size[]">
                                            <option selected>Chọn kích cỡ/phiên bản</option>
                                            @foreach ($list_product_size as $item)
                                            <option value="{{ $item->id }}">{{ $item->size_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group row ">
                                    <label for="" class="col-sm-4 control-label">Ảnh:</label>
                                    <div class="col-sm-8">
                                        <input id="img" type="file" name="thumbnail[]" class="form-control d-none"
                                            onchange="changeImg(this)">
                                        <img id="avatar" class="img-thumbnail d-block" width="300px"
                                            src="{{ asset('storage/app/public/images/upload_img.png') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btn_save" value="Thêm mới" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
