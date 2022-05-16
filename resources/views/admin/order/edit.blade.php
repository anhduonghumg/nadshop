@extends('layouts.admin')
@section('title','Danh sách đơn hàng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Sửa đơn hàng
        </div>
        <div class="card-body">
            <form method='POST' id="form_update">
                <div class="tab-content" id="myTabContent">
                    <div class="form-group">
                        <label for="fullname">Tên khách hàng</label>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            value="{{ $order->fullname}}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $order->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $order->email }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ $order->address }}">
                    </div>
                    <div class="form-group">
                        <label for="order_status">Trạng thái đơn hàng</label>
                        <input type="text" class="form-control" id="order_status" value="{{ $order->order_status }}"
                            disabled>
                    </div>
                    <div class="form-group">
                        <label for="order_status">Hình thức thanh toán</label><br>
                        @if($order->payment == 'cod')
                        <input type="radio" id="cod" name="payment" value="cod" checked>
                        <label for="cod" class="mr-3">COD</label>
                        <input class="ml-3" type="radio" id="card" name="payment" value="card">
                        <label for="card">Card</label><br>
                        @elseif($order->payment == 'card')
                        <input type="radio" id="cod" name="payment" value="cod">
                        <label for="cod" class="mr-3">COD</label>
                        <input class="ml-3" type="radio" id="card" name="payment" value="card" checked>
                        <label for="card">Card</label><br>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="note">Ghi chú</label>
                        <textarea class="form-control" rows="3" id="note" name="note">{{ $order->note }}</textarea>
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Giá tiền</th>
                                    <th scope="col">Tổng giá tiền</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @foreach ($product_order as $product)
                                <tr>
                                    <td>{{ $product->product_detail_name }}</td>
                                    <td>{{ $product->pro_order_qty }}</td>
                                    <td>{{ currentcyFormat($product->product_price) }}</td>
                                    <td>{{ currentcyFormat($product->pro_order_qty * $product->product_price) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <div class="cart-total text-right">
                            <strong>Tổng số lượng sản phẩm: <span class="total_qty">0</span></strong><br>
                            <strong>Tổng tiền: <span class="total_price">0</span></strong>
                        </div> --}}
                    </div>
                </div>
                <button type="button" id="btn_order_update" name="btn_update" class="btn btn-primary">Lưu</button>
                <input type="hidden" id="order_id" value="{{ $order->id}}">
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','#btn_order_update',function(){
        let id = $('#order_id').val();
        let fm_data = $('#form_update').serializeArray();
        fm_data.push({ name: "id", value: id });

        $('.loadajax').show();
        $.ajax({
            url: "{{ route('admin.order.update') }}",
            type: "post",
            data: fm_data,
            dataType: "json",
            success: function (rsp) {
                $('.loadajax').hide();
                if ($.isEmptyObject(rsp.errors)) {
                    confirm_success(rsp.success);
                    setTimeout(function(){
                        window.location.href = "http://localhost:8080/nadshop/admin/order/list";
                    },1000)
                } else {
                    confirm_warning(rsp.errors);
                }
            },error: function () {
                alert("error!!!!");
            },
        });
})
</script>
@endsection
