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

        label {
            margin-right: 70px;
            width: 110px;
            text-align: end;
        }
    </style>
    <div id="main-content-wp" class="checkout-page text-center">
        <div class="head">
            <h1 class="text-center">Thông tin cá nhân</h1>
        </div>
        <div id="content" class="container-fluid">
            <div class="text-center">
                <form id="form-profit-edit">
                    <section class="mb-3">
                        <label for="fullname" class="">Họ tên:</label>
                        <input id="fullname" class="w-50 p-1" type="text" name="fullname"
                            value="{{ $customer->fullname }}" placeholder="Họ tên">
                    </section>
                    <section class="mb-3">
                        <label for="birthday" class="">Ngày sinh:</label>
                        <input id="birthday" class="w-50 p-1" type="text" name="birthday"
                            value="{{ formatDate($customer->birthday) }}" placeholder="Ngày sinh">
                    </section>
                    <section class="mb-3">
                        <label for="phone" class="">Điện thoại:</label>
                        <input id="phone" class="w-50 p-1" type="text" name="phone" value="{{ $customer->phone }}"
                            placeholder="Số điện thoại">
                    </section>
                    <section class="mb-3">
                        <label for="email" class="">Email:</label>
                        <input id="email" class="w-50 p-1" type="text" name="email" placeholder="email"
                            value="{{ $customer->email }}" disabled>
                    </section>
                    <section class="mb-3">
                        <label for="address" class="">Địa chỉ:</label>
                        <input class="w-50 p-1" type="text" name="address" value="{{ $customer->address }}"
                            placeholder="Địa chỉ">
                    </section>
                    <section class="mb-3">
                        <input type="hidden" name="id" value="{{ $customer->id }}">
                        <button type="button" class="btn btn-primary btn_update">Cập nhập</button>
                        <a href="{{ route('client.profile') }}" class="btn btn-primary">Quay lại</a>
                    </section>
                </form>
            </div>

        </div>
    </div>
    <script>
        $(function() {
            $("#birthday").datepicker({
                monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4",
                    "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9",
                    "Tháng 10", "Tháng 11", "Tháng 12"
                ],
                dateFormat: "dd/mm/yy",
                dayNamesMin: ["T2", "T3", "T4", "T5", "T6", "T7", "CN"],
                changeMonth: true,
                changeYear: true,
                yearRange: "-40:+40"
            });
        });
    </script>
    <script>
        $(document).on('click', '.btn_update', function() {
            let form_update = $('#form-profit-edit').serialize();
            $.ajax({
                url: "{{ route('client.customerUpdateInfo') }}",
                type: "POST",
                data: form_update,
                dataType: "json",
                success: function(rsp) {
                    if ($.isEmptyObject(rsp.errors)) {
                        confirm_success(rsp.success);
                        location.reload();
                    } else {
                        confirm_warning(rsp.errors);
                    }
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        });
    </script>
@endsection
