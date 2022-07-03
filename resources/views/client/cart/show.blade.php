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
    <div class="row px-xl-5">
        <div class="col-lg-9 table-responsive mb-5">
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
                <tbody class="align-middle" id="show_cart">
                    <tr>
                        <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"> Colorful
                            Stylish Shirt</td>
                        <td class="align-middle">$150</td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-secondary text-center"
                                    value="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">$150</td>
                        <td class="align-middle"><button class="btn btn-sm btn-primary"><i
                                    class="fa fa-times"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-3">
            <h4>Tóm tắt đơn hàng</h4>
            <span>Chưa bao gồm phí ship:</span>
            <section class="total_cart d-flex justify-content-between">
                <h6>Tổng tiền:</h6>
                <span class="show_total"></span>
            </section>
            <a href="{{ route('client.cart.checkout') }}" class="form-control btn btn-dark mb-2">Tiến hành đặt hàng</a>
            <a href="{{ route('client.home') }}" class="form-control btn btn-outline-dark">Mua thêm sản phẩm</a>
        </div>
    </div>
</div>
<!-- Cart End -->
<script type="text/javascript">
    load_cart();
    $(document).on('click','.btn_delete_cart',function(){
        let confirm_delete = confirm("Bạn có chắc chắn muốn xóa không?");
        if(confirm_delete == true) {
        let key = Number($(this).data('key'));
        let old_data = JSON.parse(localStorage.getItem('data_cart'));
        old_data.splice(key,1);
        localStorage.setItem('data_cart', JSON.stringify(old_data));
        $("#item-" + key).remove();
        load_cart();
        num_in_cart();
        }
    });

    $('body').on('input','.product_quantity',function(){
          let qty = Number($(this).val());
          let key = $(this).data('key');
          let id = $(this).data('id');
          let old_cart_data = JSON.parse(localStorage.getItem('data_cart'));
          const total_price = old_cart_data.find(item => {
              if(item.id === id) {
                item.qty = qty;
                return true;
              }
              return false;
            });
        localStorage.setItem('data_cart',JSON.stringify(old_cart_data));
        let show_total_price = currencyFormat(total_price.qty * total_price.price);
        $('#item-' + key + ' .total_price').html(show_total_price);
        num_in_cart();
        show_total_cart();
        });

    function update_total_cart(){
        let total_cart = JSON.parse(localStorage.getItem('data_cart')).reduce(function(sum, current) {
            return sum + (current.qty * current.price);
          }, 0);
        return currencyFormat(total_cart);
    }

    function show_total_cart(){
        let show_total = update_total_cart();
        $('.show_total').html(show_total);
    }

   function load_cart(){
    if(localStorage.getItem('data_cart') != null){
        let show_cart = render_cart();
        $('#show_cart').html(show_cart);
         show_total_cart();
     }else{
        let html = `<tr><td>Giỏ hàng trống.Nhấn vào đây để mua sắm <a href="http://localhost/nadshop">shopping now</a></td></tr>`;
        $('#show_cart').html(html);
     }
}

function render_cart(){
    var output = '';
    let data = JSON.parse(localStorage.getItem('data_cart'));
    if(data.length > 0){
    $.each(data, function (key, value){
        var price = currencyFormat(value.price);
        var total_price = value.price * value.qty;
        var path_img = asset(value.thumbnail);
        output += `<tr id="item-${key}">
            <td class="align-middle"><img src="${path_img}" alt="" style="width: 50px;height:50px">${value.name}</td>
            <td class="align-middle">${price}</td>
            <td class="align-middle">
                <div class="input-group quantity mx-auto" style="width: 100px;">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary btn-minus btn_qty">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control form-control-sm bg-secondary text-center product_quantity"
                        value="${value.qty}" data-key="${key}" data-id="${value.id}">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary btn-plus btn_qty">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </td>
            <td class="align-middle total_price">${currencyFormat(total_price)}</td>
            <td class="align-middle"><button class="btn btn-sm btn-primary btn_delete_cart" data-key="${key}"><i
                        class="fa fa-times"></i></button></td>
        </tr>`;
    });
}else{
    output += `<tr><td>Giỏ hàng trống.Nhấn vào đây để mua sắm <a href="http://localhost/nadshop">shopping now</a></td></tr>`;
}
    return output;
}


</script>
@endsection
