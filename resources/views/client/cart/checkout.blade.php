@extends('layouts.client')
@section('content')
<div class="breadcrumb-shop clearfix bg-none px-xl-5">
    <div class="clearfix">
        <div class="">
            <ol class="breadcrumb breadcrumb-arrows clearfix">
                <li><a href="{{ route('client.cart.show') }}" target="_self"><i
                            class="fas fa-shopping-cart text-primary"></i>Giỏ hàng</a><i
                        class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                <li>Thanh toán</li>
            </ol>
        </div>
    </div>
</div>
<div class="container-fluid pt-5">
    <h4 class="font-weight-semi-bold mb-4 px-xl-5">Thông tin đơn hàng</h4>
    <div class="row px-xl-5">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Họ và tên</label>
                <input class="form-control" type="text" placeholder="Họ và tên">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input class="form-control" type="text" placeholder="Số điện thoại">
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input class="form-control" type="text" placeholder="Địa chỉ">
            </div>
            <div class="form-group">
                <label>Tỉnh/Thành phố</label>
                <select class="form-control" name="city" id="city">
                    <option value="">Tỉnh/Thành phố</option>
                    @if($list_city->isNotEmpty())
                    @foreach ($list_city as $city )
                    <option value="{{$city->id }}">{{ $city->city_name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>Quận/Huyện</label>
                <select class="form-control" name="district" id="district">
                </select>
            </div>
            <div class="form-group">
                <label>Ghi Chú</label>
                <textarea class="form-control" rows="5" placeholder="Ghi chú"></textarea>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-secondary mb-5">
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Sản phẩm</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody id="show_data_product">
                                <tr>
                                    <td><img src="" alt=""></td>
                                    <td>Áo phông 00921</td>
                                    <td>
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus btn_qty">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text"
                                                class="form-control form-control-sm bg-secondary text-center product_quantity"
                                                value="1" data-key="0" data-id="59">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus btn_qty">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>120.000đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mt-0">
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Phí vận chuyển</h6>
                        <h6 class="font-weight-medium">Chọn nhà vận chuyển</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Tổng cộng:</h5>
                        <h5 class="font-weight-bold show_total_cart">500.0000đ</h5>
                    </div>
                </div>
            </div>
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Phương thức thanh toán</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="paypal">
                            <label class="custom-control-label" for="paypal">COD</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                            <label class="custom-control-label" for="directcheck">MOMO</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Hoàn tất đơn
                        hàng</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout End -->
<script type="text/javascript">
    load_product_cart();
    show_total_price();

    $('body').on('input','.product_qty',update_qty_product);
    $('body').on('click','.remove_product_cart',delete_product_cart);
    $('body').on('change','#city',function(){
        let city = $('#city').val();
        $.ajax({
            url: "{{ route('client.district') }}",
            type: "POST",
            data: { city:city },
            dataType: "json",
            success: function (rsp) {
              let show = render_district(rsp);
              $('#district').html(show);
            },error: function () {
           alert("error!!!!");
            },
        });
    });

    function load_product_cart(){
        if(localStorage.getItem('data_cart') != null){
            let show_data = render_product_cart();
            $('#show_data_product').html(show_data);
       }
    }

    function render_product_cart(){
        let output = '';
        let data = JSON.parse(localStorage.getItem('data_cart'));
        $.each(data, function (key, value){
            let path_imgage = asset(value.thumbnail);
            let price = currencyFormat(value.price);
            let total = currencyFormat(value.price * value.qty);
            output +=`<tr id="pro-${key}">
            <td><img src="${path_imgage}" alt="" width='65px' height="65px"></td>
            <td>${value.name}</td>
            <td>
                <div class="input-group quantity mx-auto" style="width: 100px;">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary btn-minus btn_qty">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text"
                        class="form-control form-control-sm bg-secondary text-center product_qty"
                        value="1"  data-key="${key}" data-id="${value.id}">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary btn-plus btn_qty">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </td>
            <td class="total_price">${total}</td>
            <td class="remove_product_cart" data-key="${key}"><i class="far fa-trash-alt"></i></td>
        </tr>`;
        });
        return output;
    }

    function render_district(data){
        let output = '';
        $.each(data, function (key, value){
            output +=`<option value="${value.id}">${value.district_name}</option>`;
        });
        return output;
    }

    function update_qty_product(){
        let qty = Number($(this).val());
        let key = $(this).data('key');
        let id = $(this).data('id');
        let old_cart_data = JSON.parse(localStorage.getItem('data_cart'));
        const total = old_cart_data.find(item => {
            if(item.id === id) {
              item.qty = qty;
              return true;
            }
            return false;
          });
      localStorage.setItem('data_cart',JSON.stringify(old_cart_data));
      let show_price = currencyFormat(total.qty * total.price);
      $('#pro-' + key + ' .total_price').html(show_price);
      num_in_cart();
      show_total_price();
    }

    function update_total_price(){
        let total_cart = JSON.parse(localStorage.getItem('data_cart')).reduce(function(sum, current) {
            return sum + (current.qty * current.price);
          }, 0);
        return currencyFormat(total_cart);
    }

    function show_total_price(){
        let show_total = update_total_price();
        $('.show_total_cart').html(show_total);
    }

    function delete_product_cart(){
        let confirm_delete = confirm("Bạn có chắc chắn muốn xóa không?");
        if(confirm_delete == true) {
        let key = Number($(this).data('key'));
        let old_data = JSON.parse(localStorage.getItem('data_cart'));
        old_data.splice(key,1);
        localStorage.setItem('data_cart',JSON.stringify(old_data));
        $("#pro-" + key).remove();
        num_in_cart();
        show_total_price();
        load_product_cart();
    }

}

</script>
@endsection
