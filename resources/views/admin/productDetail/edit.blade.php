<div class="modal fade draggable edit-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog modal-lg ui-draggable">
        <div class="modal-content p-3">
            <form method='POST'>
                <div class="modal-header ui-dranggale-handle" style="cursor: move;">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <ul class="nav nav-tabs mt-3 mb-3" id="myTab">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="p_1-tab" data-toggle="tab" href="#p_1" role="tab"
                            aria-selected="true">Tab</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <input type="hidden" name="reqID" value="" id="req-id">
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
                                            <option value="" selected>Chọn màu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="size_ver" class="col-sm-4 control-label">Kích
                                        cỡ/bản:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="size_ver" name="product_size[]">
                                            <option value="" selected>Chọn kích cỡ/phiên bản</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Ảnh:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="thumbnail" name="product_thumbnail[]">
                                            <option value="" selected>Chọn ảnh chi tiết</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <input type="submit" name="btn_save" value="Thêm mới" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
