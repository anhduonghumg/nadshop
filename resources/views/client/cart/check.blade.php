@extends('layouts.client')
@section('content')
    <style>
        .icon-order-fail {
            font-size: 100px;
            color: red;
            margin-bottom: 20px;
        }
    </style>
    <div id="main-content-wp" class="checkout-page text-center">
        <div class="order-success">
            {{-- <span class="icon-success"><i class="fas fa-check-circle icon-order-success"></i></span>
        <p>Đơn hàng <strong>#{{ $code }}</strong> đã được ghi nhận!</p>
        <p>Cảm ơn quý khách đã đặt hàng tại <strong>NAD SHOP</strong>!</p>
        <p>Chúng tôi sẽ liên hệ với quý khách để xác nhận đơn hàng trong thời gian sớm nhất!</p>
        <p>Quý khách kiểm tra email để xem chi tiết đơn hàng!</p>
        <p>Xin chân thành cảm ơn!</p> --}}
        </div>
    </div>
    <script>
        get_date_vn_pay();

        function get_date_vn_pay() {
            let order_code = getParameterByName('vnp_TxnRef');
            let transaction = getParameterByName('vnp_TransactionStatus');
            if (order_code == null || transaction == null) {
                window.location.href = "http://localhost/nadshop/";
            } else {
                $.ajax({
                    url: "{{ route('confirm_vnpay') }}",
                    type: "post",
                    data: {
                        order_code: order_code,
                        transaction: transaction,
                    },
                    dataType: "json",
                    success: function(rsp) {
                        $('.loading').hide();
                        if (rsp.status = 201) {
                            localStorage.removeItem('data_cart');
                            $('.order-success').html(rsp.success);
                            console.log(rsp.success);
                        } else {
                            $('.order-success').html(rsp.errors);
                            console.log(rsp.errors);
                        }
                        is_fetching = false;
                    },
                    error: function() {
                        $('.loading').hide();
                        alert("error!!!!");
                        is_fetching = false;
                    },
                });
            }
        }

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>
@endsection
