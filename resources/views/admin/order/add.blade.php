@extends('layouts.admin')
@section('title','Danh sách đơn hàng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm đơn hàng mới
        </div>
        <div class="card-body">
            <form method='POST'>
                <div class="tab-content" id="myTabContent">
                    <div class="form-group">
                        <label for="fullname">Tên khách hàng</label>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            placeholder="Nhập tên khách hàng...">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            placeholder="Nhập số điện thoại...">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email...">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="Nhập địa chỉ...">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">

                            <select class="custom-select form-control" id="city" required="">
                                <option value="">Tỉnh/Thành phố</option>
                                @if($list_city->isNotEmpty())
                                @foreach ($list_city as $city )
                                <option value="{{$city->id }}">{{ $city->city_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">

                            <select class="custom-select form-control" id="district" required="">
                                <option value="">Quận/Huyện</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order_status">Trạng thái đơn hàng</label>
                        <select class="custom-select form-control" id="order_status" name="order_status" required="">
                            <option value="">Chọn trang thái</option>
                            @if($list_status->isNotEmpty())
                            @foreach ($list_status as $status )
                            <option value="{{$status->status_value }}">{{ $status->status_name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order_status">Hình thức thanh toán</label><br>
                        <input type="radio" id="cod" name="payment" value="cod">
                        <label for="cod" class="mr-3">COD</label>
                        <input class="ml-3" type="radio" id="card" name="payment" value="card">
                        <label for="card">Card</label><br>
                    </div>
                    <div class="form-group">
                        <label for="note">Ghi chú</label>
                        <textarea class="form-control" rows="3" id="note" name="note"></textarea>
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Giá tiền</th>
                                    <th scope="col">Tổng giá tiền</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr id="row1">
                                    <td width="40%">
                                        <select name="product_name" id="product_name" class="form-control">
                                            <option value="">Chọn sản phẩm</option>
                                            @if($list_product->isNotEmpty())
                                            @foreach ($list_product as $product )
                                            <option value="{{$product->id }}">{{ $product->product_detail_name }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td><input type="number" min="0" class="form-number" name="qty[]" id="qty"
                                            value="0">
                                    </td>
                                    <td><span class="price"></span></td>
                                    <td><span class="total"></span></td>
                                    <td>
                                        <button type="button" class="btn-primary btn-add"><i class="fa fa-plus"
                                                aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-total text-right">
                            <strong>Tổng số lượng sản phẩm: <span class="total_product">0</span></strong><br>
                            <strong>Tổng tiền: <span class="total_price">0</span></strong>
                        </div>
                    </div>
                </div>
                <input type="submit" name="btn_save" value="Thêm mới" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var count = 1;

    $(document).on('change','#city',function(e){
        let city = $('#city').val();
        $.ajax({
            url: "{{ route('admin.order.district') }}",
            type: "GET",
            data: { city:city },
            dataType: "html",
            success: function (rsp) {
                $('#district').html(rsp);
            },error: function () {
           alert("error!!!!");
            },
        });
});

    $(document).on('click','.btn-add',function(){
        count = count + 1;
        let select_output = $('table.table tbody #product_name').html();
        let num = $('tbody.table-body tr').length;
        if(num <= 4){
        let show = show_html(count,select_output);
        $('tbody.table-body').append(show);
        }
    });

    $(document).on('click','.remove',function(){
        let delete_row = $(this).data("row");
        $('#' + delete_row).remove();
    });

    $(document).on('change','#product_name',function(){
        let product = $(this).val();
        let row_id = $(this).parents('tr').attr('id');
        $.ajax({
            url: "{{ route('admin.order.add') }}",
            type: "GET",
            data: { product:product },
            dataType: "json",
            success: function (rsp) {
                let product = rsp.product;
                if(product == null){
                    $('tbody.table-body tr#' + row_id + ' td span.price').html('');
                    $('tbody.table-body tr#' + row_id + ' td span.total').html('');
                }else{
                    let price = rsp.product.product_price;
                    let total = price;
                $('tbody.table-body tr#' + row_id + ' td span.price').html(price);
                $('tbody.table-body tr#' + row_id + ' td span.total').html(total);
                }
            },error: function () {
           alert("error!!!!");
            },
        });
    });

    $(document).on('change','#qty',function(){
        let qty = $(this).val();


    });

    function show_html($count,data){
        var html_code = `<tr id='row${count}'>`;
            html_code += `<td width="40%">
                   <select name="product_name" id="product_name" class="form-control">`;
                    html_code += `${data}`;
            html_code += `</select></td>
               <td><input type="number" min="0" class="form-number" name="qty[]" id="qty"
                       value="0">
               </td>
               <td><span class="price"></span></td>
               <td><span class="total"></span></td>
               <td><button type='button' class='btn-danger remove' name='remove' data-row='row${count}'><i class="fa fa-minus" aria-hidden="true"></i></button></td>
           </tr>`;
        return html_code;
    }
</script>
@endsection
