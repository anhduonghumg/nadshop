<div class="modal fade draggable variant_modal" id="variant_modal" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog modal-lg ui-draggable" role="document">
        <div class="modal-content p-3">
            <form id="fm_variant_product" method="POST">
                <div class="modal-header ui-dranggale-handle" style="cursor: move;">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class='info-product my-3'>
                    <strong for="">Tên sản phẩm gốc: </strong>
                    <span>{{ $info_product->product_name }}</span>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="" role="tabpanel" aria-labelledby="">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 control-label">Tên sản
                                        phẩm:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control product_detail_name"
                                            placeholder="Tên sản phẩm" name="product_detail_name">
                                        <p class="error_msg" id="product_detail_name"></p>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label for="cost_price" class="col-sm-4 control-label">Giá nhập:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control cost_price"
                                            placeholder="Giá nhập sản phẩm (VNĐ)" name="cost_price">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label for="product_price" class="col-sm-4 control-label">Giá bán:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control product_price"
                                            placeholder="Giá bán sản phẩm (VNĐ)" name="product_price">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="product_discount" class="col-sm-4 control-label">Khuyến
                                        mãi:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control product_discount"
                                            placeholder="Khuyến mãi (%)" name="product_discount">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="stock" class="col-sm-4 control-label">Số
                                        lượng:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control stock" placeholder="Số lượng sản phẩm"
                                            name="product_qty_stock">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="color" class="col-sm-4 control-label">Màu:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control color" name="product_color">
                                            <option value="" selected>Chọn màu</option>
                                            @foreach ($list_product_color as $item)
                                            <option value="{{ $item->id }}">{{ $item->color_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"><label for="size_ver" class="col-sm-4 control-label">Kích
                                        cỡ/bản:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control size_ver" name="product_size">
                                            <option value="" selected>Chọn kích cỡ</option>
                                            @foreach ($list_product_size as $item)
                                            <option value="{{ $item->id }}">{{ $item->size_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Ảnh chi tiết:</label>
                                    <div class="col-sm-8">
                                        <select id="select_thumbnail" class="form-control thumbnail"
                                            name="product_details_thumb">
                                            <option value="" selected>Chọn ảnh chi tiết</option>
                                            @foreach ($list_image as $item)
                                            <option
                                                data-imagesrc="{{ asset('storage/app/public/images/product/thumb').'/'.$item->image }}"
                                                value="{{ $item->image }}"></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <input type="button" id="btn_save_variant" data-id="{{ $id }}" name="btn_save" class="btn btn-primary"
                        value="Lưu">
                </div>
            </form>
        </div>
    </div>
</div>
{{-- <input type="hidden" id="url_product_detail" data-url="" data-id="">
<div class="print-error-msg">
</div> --}}
