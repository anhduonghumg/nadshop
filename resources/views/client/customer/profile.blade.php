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
    </style>
    <div id="main-content-wp" class="checkout-page text-center">
        <div class="head">
            <h1 class="text-center">Tài khoản</h1>
        </div>
        <div class="content">
            <div class="row px-xl-5">
                <div class="col-md-6">
                    <h5 style="margin-left:16px;" class="text-left mr-2 underline">Thông tin tài khoản</h3>
                        <div class="profiile-item">
                            <ul class="list_item_info">
                                <li>
                                    <p href="">Điểm tích lũy của bạn: <strong>{{ $point }}</strong></p>
                                </li>
                                <li>
                                    <p href="">Cấp độ khách hàng: <strong>{{ translate_point($point) }}</strong></p>
                                </li>
                                <li>
                                    <a href="{{ route('client.profileEdit') }}">Thay đổi thông tin tài khoản</a>
                                </li>
                                <li>
                                    <a href="{{ route('client.changePass') }}">Thay đổi mật khẩu</a>
                                </li>
                            </ul>
                        </div>
                </div>
                <div class="col-md-6">
                    <h5 class="text-left underline">Quản lí đơn hàng</h3>
                        <ul class="list_item_info">
                            <li>
                                <a href="{{ route('client.orderHistory') }}">Lịch sử mua hàng</a>
                            </li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
