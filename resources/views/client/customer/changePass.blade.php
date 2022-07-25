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
            width: 170px;
            text-align: end;
        }
    </style>
    <div id="main-content-wp" class="checkout-page text-center">
        <div class="head">
            <h1 class="text-center">Đi mật khẩu</h1>
        </div>
        <div id="content" class="container-fluid">
            <div class="text-center">
                <form id="form-change-pass">
                    <section class="mb-3">
                        <label for="old_pass" class="">Mật khẩu cũ:</label>
                        <input id="old_pass" class="w-50 p-1" type="password" name="old_pass" placeholder="Mật khẩu cũ">
                    </section>
                    <section class="mb-3">
                        <label for="new_pass" class="">Mật khẩu mới:</label>
                        <input id="new_pass" class="w-50 p-1" type="password" name="new_pass" placeholder="Mật khẩu mới">
                    </section>
                    <section class="mb-3">
                        <label for="corfirm_pass" class="">Xác nhận mật khẩu:</label>
                        <input id="corfirm_pass" class="w-50 p-1" type="password" name="confirm_pass"
                            placeholder="Xác nhận mật khẩu">
                    </section>
                    <section class="mb-3">
                        <input type="hidden" name="id" value="{{ $customer->id }}">
                        <button type="button" class="btn btn-primary btn_change">Thay đổi</button>
                        <a href="{{ route('client.profile') }}" class="btn btn-primary">Quay lại</a>
                    </section>
                </form>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).on('click', '.btn_change', function() {
            let change_pass = $('#form-change-pass').serialize();
            $.ajax({
                url: "{{ route('client.updatePass') }}",
                type: "POST",
                data: change_pass,
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
