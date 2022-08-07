<div class="modal fade draggable edit-stock-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog modal-lg ui-draggable">
        <div class="modal-content p-3">
            <form method='POST' id="form_edit_stock">
                <div class="modal-header ui-dranggale-handle" style="cursor: move;">
                    <h5 class="modal-title" id="exampleModalLabel">Cập nhập số lượng sản phẩm</h5>
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
                    <input type="hidden" name="productId" value="{{ $product->id }}" id="req-id">
                    <div class="tab-pane fade show active" id="p_1" role="tabpanel" aria-labelledby="p_1-tab">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 control-label">Tên sản
                                        phẩm:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="product_name"
                                            placeholder="Tên sản phẩm" name="product_detail_name[]"
                                            value="{{ $product->product_detail_name }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="stock" class="col-sm-4 control-label">Số
                                        lượng:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="stock"
                                            placeholder="Số lượng sản phẩm" name="product_qty_stock"
                                            value="{{ $product->product_qty_stock }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <input type="button" name="btn_update_stock" value="Cập nhập"
                            class="btn btn-primary btn_update_stock">
                    </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.btn_update_stock', function() {
        let form = $('#form_edit_stock').serialize();
        $.ajax({
            url: "{{ route('admin.product.update.stock') }}",
            type: "POST",
            data: form,
            success: function(data) {
                if ($.isEmptyObject(data.errors)) {
                    confirm_success(data.success);
                    $('.edit-stock-modal').modal('hide');
                    location.reload();
                } else {
                    confirm_warning(data.errors);
                }
            },
            error: function() {
                alert('Xảy ra lỗi');
            }
        });
    })
</script>
