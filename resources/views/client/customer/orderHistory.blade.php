@extends('layouts.client')
@section('content')
    <style>
        .head {
            margin-top: 60px;
            margin-bottom: 40px;
        }

        .underline {
            border-bottom: 1px solid black;
            margin-bottom: 10px;
        }

        ul.list_item_info {
            list-style: none;
            text-align: left;
            padding: 0px;
            margin-left: 16px;
            color: black;
            font-size: 14px;
        }

        ul.list_item_info li {
            margin-top: 10px;
        }

        ul.list_item_info li a {

            color: #252a2b;

        }

        .table-bordered {
            border: 1px solid black
        }

        .table-bordered td {
            border-color: black;
        }

        .table-bordered th {
            border-color: black;
        }

        .table thead th {
            border-bottom: 1px solid black;
        }
    </style>
    <div id="main-content-wp" class="checkout-page text-center">
        <div class="head">
            <h1 class="text-center">Lịch sử mua hàng</h1>
        </div>
        <div class="content">
            <div class="row px-xl-5">
                <div class="col-md-9">
                    <h5 style="margin-left:16px;" class="text-left mr-2 underline">Đơn hàng</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Giá trị</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_history as $item)
                                    <tr>
                                        <td>{{ $item->order_code }}</td>
                                        <td>{{ currentcyFormat($item->order_total) }}</td>
                                        <td>{{ translate_order($item->order_status) }}</td>
                                        <td>{{ formatDate($item->order_date) }}</td>
                                        <td>
                                            <a style="cursor: pointer;" class="show_detail_order"
                                                data-id="{{ $item->id }}">Chi tiết</a>
                                            @if ($item->order_status == 'pending')
                                                <a style="cursor: pointer;" class="cancel_order"
                                                    data-id="{{ $item->id }}">Hủy đơn</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $order_history->links('layouts.paginationlink') }}
                </div>
                <div class="col-md-3">
                    <h5 class="text-left underline">Tài khoản</h3>
                        <ul class="list_item_info">
                            <li>
                                <a href="{{ route('client.orderHistory') }}">Lịch sử mua hàng</a>
                            </li>
                            <li>
                                <a href="{{ route('client.profile') }}">Thông tin tài khoản</a>
                            </li>
                            <li>
                                <a href="{{ route('client.logout') }}">Đăng xuất</a>
                            </li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="show_modal_detail"></div>
    <script>
        $(document).on('click', '.show_detail_order', function(e) {
            //$(".loadajax").show();
            e.preventDefault();
            let order = $(this).data('id');
            $.ajax({
                url: "{{ route('client.orderDetail') }}",
                data: {
                    order: order
                },
                type: "POST",
                dataType: "json",
                success: function(rsp) {
                    //$(".loadajax").hide();
                    $("#show_modal_detail").html(rsp);
                    $('#modal_history').modal('show');
                },
                error: function() {
                    //$(".loadajax").hide();
                    alert("error!!!!");
                },
            });

        });

        $(document).on('click', '.cancel_order', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('client.orderCancel') }}",
                data: {
                    id: id
                },
                type: "POST",
                dataType: "json",
                success: function(rsp) {
                    //$(".loadajax").hide();
                    $("#show_modal_detail").html(rsp);
                    $('#modal_cancel').modal('show');
                },
                error: function() {
                    //$(".loadajax").hide();
                    alert("error!!!!");
                },
            });

        });
    </script>
@endsection
