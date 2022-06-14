@extends('layouts.client')
@section('content')
<div class="breadcrumb-shop clearfix bg-none px-xl-5">
    <div class="clearfix">
        <div class="">
            <ol class="breadcrumb breadcrumb-arrows clearfix">
                <li><a href="{{ route('client.home') }}" target="_self"><i class="fa fa-home"></i>Trang chủ</a><i
                        class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                <li>Giỏ hàng</li>
            </ol>
        </div>
    </div>
</div>

<!-- Cart Start -->
<div class="container-fluid">
    <h3 class='px-xl-5 pb-3'>Giỏ hàng của tôi</h3>
    <div id="load_cart"></div>
</div>

{{-- <div class="container-fluid pt-5">
    <div class="row px-xl-5">

    </div>
</div> --}}
<!-- Cart End -->
<script type="text/javascript">
    //var data_cart = localStorage.getItem('data_cart');
    var output = `<div class="row px-xl-5 pb-3">`;
        output += `<div class="col-lg-9 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá tiền</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody class="align-middle">`;
    if(localStorage.getItem('data_cart') != null){
        var data = JSON.parse(localStorage.getItem('data_cart'));
        var total_cart = update_total_cart(data);
       $.each(data, function (key, value){
           var price = currencyFormat(value.price);
           var total_price = value.price * value.qty;
            output += `<tr>
                    <td class="align-middle"><img src="http://localhost:8080/nadshop/${value.thumbnail}" alt="" style="width: 50px;height:50px">${value.name}</td>
                    <td class="align-middle">${price}</td>
                    <td class="align-middle">
                        <div class="input-group quantity mx-auto" style="width: 100px;">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control form-control-sm bg-secondary text-center"
                                value="${value.qty}">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">${currencyFormat(total_price)}</td>
                    <td class="align-middle"><button class="btn btn-sm btn-primary btn_delete_cart" data-key=${key}><i
                                class="fa fa-times"></i></button></td>
                </tr>`;
      });
    }else{
        output += `<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <p>Không có dữ liệu.</p>
        </div>`;
    }
    output += `</tbody></table></div>`;
    output += `<div class="col-lg-3">`;
    output += `<h4>Tóm tắt đơn hàng</h4>
        <span>Chưa bao gồm phí ship:</span>
        <section class="total_cart d-flex">
            <h6>Tổng tiền:</h6>
            <span class="show_total">${currencyFormat(total_cart)}</span>
        </section>
        <button class="form-control btn-dark mb-2">Tiến hành đặt hàng</button>
        <button class="form-control btn-outline-dark">Mua thêm sản phẩm</button>
    </div>`;
    output += `</div>`;
   $('#load_cart').html(output);

    $(document).on('click','.btn_delete_cart',function(){
        let choice = confirm("Bạn thực sự muốn xóa?");
        if(choice == true){
            var key_item = Number($(this).data('key'));
            var data = JSON.parse(localStorage.getItem('data_cart'));
            data.splice(key_item);
           localStorage.setItem('data_cart', JSON.stringify(data));
        }
    });

    function load_cart(data_cart){

    }

    function update_total_cart(data){
        var total_cart = data.reduce(function(sum, current) {
            return sum + (current.qty * current.price);
          }, 0);
        return total_cart;
    }
</script>

@endsection
