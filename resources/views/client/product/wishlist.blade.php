@extends('layouts.client')
@section('content')
    <style>
        .remove-wishlist {
            position: absolute;
            top: 0px;
            right: -6px;
        }
    </style>
    <div class="breadcrumb-shop clearfix bg-none px-xl-5">
        <div class="clearfix">
            <div class="">
                <ol class="breadcrumb breadcrumb-arrows clearfix">
                    <li><a href="{{ route('client.home') }}" target="_self"><i class="fa fa-home"></i>Trang chủ</a><i
                            class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                    <li>Sản phẩm yêu thích</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- Shop Start -->
    <div class="container-fluid">
        <h3 class='px-xl-5 pb-3'>Sản phẩm yêu thích</h3>
        <div id="load_wishlist"></div>
    </div>
    <!-- Shop End -->
    <script type="text/javascript">
        var output = `<div class="row px-xl-5 pb-3">`;
        if (localStorage.getItem('data_wishlist') != null) {
            var data = JSON.parse(localStorage.getItem('data_wishlist'));
            $.each(data, function(key, value) {
                var price = currencyFormat(value.price);
                output += `<div id="item-${key}" class="col-lg-3 col-md-6 col-sm-12 pb-1">
    <div class="card product-item border-0 mb-4">
        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <img class="img-fluid w-100" src="${value.image}" alt="">
            <div class="remove">
                <a class="btn btn-sm remove-wishlist" data-id="${key}"><i class="far fa-times-circle icon-remove-item"></i></a>
            </div>
        </div>
        <div class="card-body border-left border-right p-0 pt-4 pb-3">
            <h6 class="text-center mb-3">${value.name}</h6>
            <div class="text-center">
                <h6>${price}</h6>
            </div>
        </div>
        <div class="card-footer bg-light border">
            <a href="${value.url}" class="btn btn-sm text-dark p-0 d-block text-center"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
        </div>
    </div></div>`;
            });
        } else {
            output += `<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <p>Không có dữ liệu.</p>
        </div>`;
        }
        output += `</div>`;
        $('#load_wishlist').html(output);

        $(document).on('click', '.remove-wishlist', function() {
            let confirm_delete = confirm("Bạn có chắc chắn muốn xóa không?");
            if (confirm_delete == true) {
                let id = $(this).data('id');
                let old_data = JSON.parse(localStorage.getItem('data_wishlist'));
                old_data.splice(id, 1);
                localStorage.setItem('data_wishlist', JSON.stringify(old_data));
                $("#item-" + id).remove();
                total = old_data.length;
                $('.wishlist_badge').html(total);
                location.reload();
            }
        })
    </script>
@endsection
