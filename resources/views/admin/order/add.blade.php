@extends('layouts.admin')
@section('title', 'Danh sách đơn hàng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm đơn hàng mới
        </div>
        <div class="card-body">
            <form method='POST' id="form_add">
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
                            <select class="custom-select form-control" name="city" id="city" required="">
                                <option value="">Tỉnh/Thành phố</option>
                                @if ($list_city->isNotEmpty())
                                @foreach ($list_city as $city)
                                <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select class="custom-select form-control" name="district" id="district" required="">
                                <option value="">Quận/Huyện</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order_status">Trạng thái đơn hàng</label>
                        <select class="custom-select form-control" id="order_status" name="order_status" required="">
                            <option value="">Chọn trang thái</option>
                            @if ($list_status->isNotEmpty())
                            @foreach ($list_status as $status)
                            <option value="{{ $status->status_value }}">{{ $status->status_name }}</option>
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
                                    <th scope="col">
                                        <button type="button" class="btn-primary btn-add"><i class="fa fa-plus"
                                                aria-hidden="true"></i></button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                {{-- <tr id="row1" class='list_pro'>
                                    <td width="40%">
                                        <select name="product_name[]" id="product_name" class="form-control">
                                            <option value="">Chọn sản phẩm</option>
                                            @if ($list_product->isNotEmpty())
                                            @foreach ($list_product as $product)
                                            <option value="{{$product->id }}">{{ $product->product_detail_name }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td><input type="number" min="1" class="form-number qty" name="qty[]" value="1">
                                    </td>
                                    <td><span class="price">0</span></td>
                                    <td><span class="total">0</span></td>
                                    <td>
                                        <button type="button" class="btn-primary btn-add"><i class="fa fa-plus"
                                                aria-hidden="true"></i></button>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                        <div class="cart-total text-right">
                            <strong>Tổng số lượng sản phẩm: <span class="total_qty">0</span></strong><br>
                            <strong>Tổng tiền: <span class="total_price">0</span></strong>
                        </div>
                    </div>
                </div>
                <button type="button" id="btn_order_save" name="btn_save" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var count = 0;
        $(document).on('change', '#city', function(e) {
            let city = $('#city').val();
            $.ajax({
                url: "{{ route('admin.order.district') }}",
                type: "GET",
                data: {
                    city: city
                },
                dataType: "html",
                success: function(rsp) {
                    $('#district').html(rsp);
                },
                error: function() {
                    alert("error!!!!");
                },
            });
        });

        $(document).on('click', '.btn-add', function() {
            count = count + 1;
            let num = $('tbody.table-body tr').length;
            $.ajax({
                url: "{{ route('admin.order.addProduct') }}",
                type: "GET",
                dataType: "json",
                success: function(rsp) {
                    let product = rsp.list_product;
                    let output = show_html(count, product);
                    if (num <= 4) {
                        $('tbody.table-body').append(output);
                    } else {
                        alert('Chỉ có thể thêm tối đa 5 sản phẩm');
                    }
                },
                error: function() {
                    alert("error!!!!");
                },
            });
        });

        $(document).on('click', '.remove', function() {
            let delete_row = $(this).data("row");
            $('#' + delete_row).remove();
            load_product();
        });

        $(document).on('change', '#product_name', function() {
            let product = $(this).val();
            let row_id = $(this).parents('tr').attr('id');
            $.ajax({
                url: "{{ route('admin.order.add') }}",
                type: "GET",
                data: {
                    product: product
                },
                dataType: "json",
                success: function(rsp) {
                    let product = rsp.product;
                    if (product == null) {
                        $('tbody.table-body tr#' + row_id + ' td span.price').html('0');
                        $('tbody.table-body tr#' + row_id + ' td span.total').html('0');
                    } else {
                        let price_discount = rsp.product.product_price * (rsp.product.product_discount *
                            1 /
                            100);
                        let price = rsp.product.product_price - price_discount;
                        let show_price = currencyFormat(price);
                        let profit = price - rsp.product.cost_price;
                        $('tbody.table-body tr#' + row_id + ' input.profit').val(profit);
                        $('tbody.table-body tr#' + row_id + ' td span.price').html(show_price);
                    }
                    load_product();
                },
                error: function() {
                    alert("error!!!!");
                },
            });
        });

        $(document).on('change', '.qty', function() {
            load_product();
        });

        $(document).on('click', '#btn_order_save', function() {

            let total_order = stringToNumber($('.total_price').text());
            let total_qty = Number($('.total_qty').text());
            let profit = 0;
            $('.table-body tr.list_pro').each(function() {
                get_profit = $(this).find('.show_profit').val();
                profit += Number(get_profit);
            });
            let fm_data = $('#form_add').serializeArray();
            fm_data.push({
                name: "order_total",
                value: total_order
            });
            fm_data.push({
                name: "order_qty",
                value: total_qty
            });
            fm_data.push({
                name: "profit",
                value: profit
            });
            console.log(profit);
            $('.loadajax').show();
            $.ajax({
                url: "{{ route('admin.order.store') }}",
                type: "post",
                data: fm_data,
                dataType: "json",
                success: function(rsp) {
                    $('.loadajax').hide();
                    if ($.isEmptyObject(rsp.errors)) {
                        confirm_success(rsp.success);
                        setTimeout(function() {
                            window.location.href =
                                "http://localhost/nadshop/admin/order/list";
                        }, 1000)
                    } else {
                        confirm_warning(rsp.errors);
                    }
                },
                error: function() {
                    alert("error!!!!");
                },
            });
        });

        function load_product() {
            let total_qty = 0;
            let total_all = 0;
            $('.table-body tr.list_pro').each(function() {
                let qty = $(this).find('.qty').val();
                let price = stringToNumber($(this).find('.price').text());
                let profit = Number($(this).find('.profit').val());
                let total = qty * price;
                let show_profit = qty * profit;
                $(this).find('.show_profit').val(show_profit);
                $(this).find('.total').text(currencyFormat(total));
                total_all += Number(total);
                total_qty += Number(qty);
            });

            $('.total_price').text(currencyFormat(total_all));
            $('.total_qty').text(total_qty);
        }

        function show_html($count, data) {
            let output = `<tr id="row${count}" class='list_pro'>
            <td width="40%">
                <select name="product_name[]" id="product_name" class="form-control">
                    <option value="">Chọn sản phẩm</option>`;
            $.each(data, function(key, value) {
                output += `<option value="${value.id}">${value.product_detail_name}</option>`;
            });
            output += `</select>
            </td>
            <td><input type="number" min="1" class="form-number qty" name="qty[]" value="1">
            </td>
            <td><span class="price">0</span></td>
            <td><span class="total">0</span></td>
            <input type="hidden" class="profit" value="0"></input>
            <input type="hidden" class="show_profit" value="0"></input>
            <td>
                <button type='button' class='btn-danger remove' name='remove' data-row='row${count}'><i class="fa fa-minus" aria-hidden="true"></i></button>
            </td>
        </tr>`;
            return output;
        }

        function stringToNumber(data) {
            var result;
            if (data != null) {
                result = data.substring(0, data.length - 1);
                result = result.replace(/\./g, '');
            }
            return result;
        }
</script>
@endsection
