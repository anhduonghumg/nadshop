@extends('layouts.admin')
@section('title','Danh sách đơn hàng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Danh sách đơn hàng
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ route('admin.order.list','status=all') }}" class="text-primary">Tất
                    cả({{ $data_num_order['all'] }})<span class="text-muted"> |</span></a>
                <a href="{{ route('admin.order.list','status=pending') }}" class="text-primary">Chờ xác
                    nhận({{ $data_num_order['pending'] }})<span class="text-muted">|</span></a>
                <a href="{{ route('admin.order.list','status=shipping') }}" class="text-primary">Vận
                    chuyển({{ $data_num_order['shipping'] }})<span class="text-muted">|</span></a>
                <a href="{{ route('admin.order.list','status=success') }}" class="text-primary">Hoàn
                    thành({{ $data_num_order['success'] }})<span class="text-muted">|</span></a>
                <a href="{{ route('admin.order.list','status=cancel') }}" class="text-primary">Hủy
                    bỏ({{ $data_num_order['cancel'] }})<span class="text-muted"></span></a>
            </div>
            {{-- <form> --}}
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option>Chọn</option>
                        <option>Xác nhận</option>
                        <option>Hoàn thành</option>
                        <option>Hủy bỏ</option>
                    </select>
                    <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary mr-3">
                    <a href="{{ route('admin.order.add') }}" class="btn btn-success btn-rounded btn-add"><i
                            class="fa fa-plus"></i> Thêm
                        mới</a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input id="checkall" name="checkall" type="checkbox">
                            </th>
                            <th scope="col">STT</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Giá trị</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thanh toán</th>
                            <th scope="col">Chi tiết </th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    @if($list_orders->isNotEmpty())
                    @php $temp = 0; @endphp
                    <tbody>
                        @foreach ($list_orders as $order)
                        @php $temp++ @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="">
                            </td>
                            <th scope="row">{{ $temp }}</th>
                            <td><strong>{{ $order['order_code'] }}</strong></td>
                            <td>
                                {{ $order['fullname'] }}
                            </td>
                            <td>{{ formatDateToDMY($order['created_at']) }}</td>
                            <td>{{ currentcyFormat($order['order_total']) }}</td>
                            <td>
                                <span class="badge badge-warning">{{ $order['order_status'] }}</span>
                            </td>
                            <td>{{ $order['payment'] }}</td>
                            <td><button type="button" class="btn btn-primary btn-sm btn-rounded order-detail" data-id={{
                                    $order['product_order_id']}}><i class="fa fa-eye" aria-hidden="true"></i></button>
                            </td>
                            <td>
                                <a href="{{ route('admin.order.edit', $order['id']) }}"
                                    class="btn btn-success btn-sm rounded-0 text-white order-edit" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit" edit-id={{
                                    $order['product_order_id']}}><i class="fa fa-edit"></i></a>
                                <a class="btn btn-danger btn-sm rounded-0 text-white order-delete" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                    delete-id="{{$order['product_order_id']}}"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @else
                    <tr>
                        <td colspan='9' class="bg-white">
                            <p>Không có bản ghi nào.</p>
                        </td>
                    </tr>
                    @endif
                </table>
                {{--
            </form> --}}
            {{ $list_orders->links('layouts.paginationlink') }}
        </div>
    </div>
</div>
<div id="modalPopup">

</div>
<script>
    $(document).on('click','.order-detail',function(){
    $(".loadajax").show();
      let order = $(this).data('id');
      $.ajax({
        url: "{{ route('admin.order.detail') }}",
        data:{order:order},
        type: "GET",
        dataType: "html",
        success: function (rsp) {
          $(".loadajax").hide();
          $("#modalPopup").html(rsp);
          $('.modal').modal('show');
        },error: function () {
         alert("error!!!!");
        },
    });
 });

 $(document).on('click','.order-delete',function(){
     let id = $(this).attr('delete-id');
     $.ajax({
        url: "{{ route('admin.order.delete') }}",
        type: "POST",
        dataType: "json",
        data: {id:id},
        beforeSend:function(){
           return confirm("Bạn thực sự muốn xóa?");
         },
        success: function (rsp) {
            $(".loadajax").hide();
            confirm_success(rsp.success);
            //loadData(page);
        },
        error: function () {
            $(".loadajax").hide();
            alert("error!!!!");
        },
    });
 });

</script>
@endsection
