@extends('layouts.client')
@section('content')
<div class="wp-check">
    <form action="" method="POST">
        <h1 class="check-title">Kiểm tra đơn hàng của bạn</h1>
        <input type="text" class="order-code" placeholder="Nhập mã đơn hàng của bạn" name="order_code">
        <button type="button" name="btn-check" class='btn-check'>Tra cứu</button>
    </form>
</div>
<script type="text/javascript">
    var is_loading = false;
    $(document).on('click','.btn-check',function(){
        if(is_loading) return false;
        let order_code = $('.order-code').val();
        is_loading = true;
        $.ajax({
            url: "{{ route('client.order.show') }}",
            type: "POST",
            data: {
              order_code:order_code
         },
            dataType: "json",
            success: function (rsp) {
                if ($.isEmptyObject(rsp.errors)) {
                    let data_order = rsp.order;
                    console.log(data_order);
                    let show = render_order(data_order);
                    $('.wp-check').html(show);
                } else {
                    confirm_warning(rsp.errors);
                }
              is_loading = false;
            },error: function () {
                alert("error!!!!");
            }
         });
    });

    function render_order(data){
      let output = '';
      let order_date = dateFormat(data.created_at,'/');
      let total = currencyFormat(data.order_total);
      let status = convertStatusOrder(data.order_status);
      output += `
      <h4>Đơn Hàng</h4>
      <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Mã sản phẩm</th>
                <th scope="col">Khách hàng</th>
                <th scope="col">Thời gian đặt</th>
                <th scope="col">Giá trị</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Chi tiết đơn</th>
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="col">${data.order_code}</td>
                <td scope="col">
                   ${data.fullname}
                </td>
                <td scope="col">${order_date}</td>
                <td scope="col">${total}</td>
                <td scope="col">${status}</td>
                <td scope="col">
                    <button type="button" class="btn btn-primary btn-sm btn-rounded order-detail" data-id="${data.product_order_id}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                </td>
                <td scope="col">
                    <button type="button" class="btn btn-primary btn-sm btn-rounded order-cancel" data-id="${data.product_order_id}">Hủy đơn</button>
                </td>
            </tr>
        </tbody>
    </table>`;
    return output;
    }
</script>
@endsection
