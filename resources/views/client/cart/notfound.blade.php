@extends('layouts.client')
@section('content')
<div id="main-content-wp" class="checkout-page text-center">
    <div class="order-success">
        <span class="icon-success"><i class="fas fa-check-circle icon-order-success"></i></span>
        <p>Đơn hàng <strong>#{{ $code }}</strong> đã được ghi nhận!</p>
        <p>Cảm ơn quý khách đã đặt hàng tại <strong>NAD SHOP</strong>!</p>
        <p>Chúng tôi sẽ liên hệ với quý khách để xác nhận đơn hàng trong thời gian sớm nhất!</p>
        <p>Quý khách kiểm tra email để xem chi tiết đơn hàng!</p>
        <p>Xin chân thành cảm ơn!</p>
    </div>
</div>
@endsection
