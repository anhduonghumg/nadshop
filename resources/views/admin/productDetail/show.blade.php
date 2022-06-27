<div class="modal fade modal-detail" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Giá (VNĐ)</th>
                            <th scope="col">Giảm giá (%)</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Sản phẩm gốc</th>
                            <th scope="col">Màu</th>
                            <th scope="col">Loại/Size</th>
                            <th scope="col">Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">1</td>
                            <td scope="col">{{ $product->product_detail_name }}</td>
                            <td scope="col">
                                <img src="{{ asset('storage/app/public/images/product/thumb').'/'.$product->product_details_thumb }}"
                                    height="80" width="80" alt="" />
                            </td>
                            <td scope="col">{{ currentcyFormat($product->product_price) }}</td>
                            <td scope="col">{{ $product->product_discount }}</td>
                            <td scope="col">{{ $product->product_qty_stock }}</td>
                            <td scope="col">{{ $product->product->product_name }}</td>
                            <td scope="col">{{ $product->color->color_name }}</td>
                            <td scope="col">{{ $product->size->size_name }}</td>
                            <td scope="col">{{ formatDateToDMY($product->created_at )}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
