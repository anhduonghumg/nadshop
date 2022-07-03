<div class="modal fade" id="" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="">Chi tiết đơn hàng</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4>Thông tin đơn hàng</h4>
                        <p class="border border-dark border-bottom-2 mb-2"></p>
                        <section class="form-group">
                            <label for="code">Mã đơn hàng</label>
                            <input type="text" class="form-control" id="code" name="code"
                                value="{{ $info_orders->order_code }}" disabled>
                        </section>
                        <section class="form-group">
                            <label for="status">Trạng thái đơn hàng</label>
                            <input type="text" class="form-control" id="status" name="status"
                                value="{{ $info_orders->order_status }}" disabled>
                        </section>
                        <section class="form-group">
                            <label for="fullname">Tên khách hàng</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                value="{{ $info_orders->fullname }}" disabled>
                        </section>
                        <section class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $info_orders->phone }}" disabled>
                        </section>
                        @if ($info_orders->email != null)
                            <section class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ $info_orders->email }}" disabled>
                            </section>
                        @endif
                        <section class="form-group">
                            <label for="address">Địa chỉ nhận</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $info_orders->address }}" disabled>
                        </section>
                        <section class="form-group">
                            <label for="payment">Hình thức thanh toán</label>
                            <input type="text" class="form-control" id="payment" name="address"
                                value="{{ $info_orders->payment }}" disabled>
                        </section>
                        @if ($info_orders->note != null)
                            <section class="form-group">
                                <label for="note">Ghi chú</label>
                                <textarea class="form-control" name="note" disabled>{{ $info_orders->note }}</textarea>
                            </section>
                        @endif
                    </div>
                    <div class="col-sm-7">
                        <h4>Sản phẩm đơn hàng</h4>
                        <p class="border border-dark border-bottom-2 mb-2"></p>
                        <section class="form-group">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Ảnh</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Đơn giá</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Thành tiền</th>
                                    </tr>
                                </thead>
                                @if ($list_product_order->isNotEmpty())
                                    @php $temp = 0; @endphp
                                    <tbody>
                                        @foreach ($list_product_order as $item)
                                            @php $temp++; @endphp
                                            <tr>
                                                <td scope="col">{{ $temp }}</td>
                                                <td scope="col"><img
                                                        src="{{ asset('storage/app/public/images/product/thumb/' . $item->product_details_thumb) }}"
                                                        width='80px' height="80px" alt=""></td>
                                                <td scope="col">{{ $item->product_detail_name }}</td>
                                                <td scope="col">
                                                    {{ currentcyFormat($item->product_price - ($item->product_price * $item->product_discount) / 100) }}
                                                </td>
                                                <td scope="col">{{ $item->pro_order_qty }}</td>
                                                <td scope="col">
                                                    {{ currentcyFormat($item->pro_order_qty * ($item->product_price - ($item->product_price * $item->product_discount) / 100)) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                            <div class="order-value text-right">
                                <strong>Tổng số lượng sản phẩm:
                                    <span>{{ $info_orders->order_qty }}</span></strong><br>
                                <strong>Tổng tiền:
                                    <span>{{ currentcyFormat($info_orders->order_total) }}</span></strong>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
