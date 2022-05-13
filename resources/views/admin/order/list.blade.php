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
                <a href="{{ route('admin.order.list','status=all') }}" class="text-primary">Tất cả<span
                        class="text-muted"> |</span></a>
                <a href="{{ route('admin.order.list','status=pending') }}" class="text-primary">Chờ xác nhận<span
                        class="text-muted">|</span></a>
                <a href="{{ route('admin.order.list','status=confirm') }}" class="text-primary">Đã xác nhận<span
                        class="text-muted">|</span></a>
                <a href="{{ route('admin.order.list','status=complete') }}" class="text-primary">Hoàn thành<span
                        class="text-muted">|</span></a>
                <a href="{{ route('admin.order.list','status=cancel') }}" class="text-primary">Hủy bỏ<span
                        class="text-muted"></span></a>
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
                            <td><strong>{{ $order->order_code }}</strong></td>
                            <td>
                                {{ $order->fullname }}
                            </td>
                            <td>{{ formatDateToDMY($order->created_at) }}</td>
                            <td>{{ currentcyFormat($order->order_total) }}</td>
                            <td>
                                <span class="badge badge-warning">{{ $order->order_status }}</span>
                            </td>
                            <td>{{ $order->payment }}</td>
                            <td><button type="button" class="btn btn-primary btn-sm btn-rounded order-detail" data-id={{
                                    $order->product_order_id}}><i class="fa fa-eye" aria-hidden="true"></i></button>
                            </td>
                            <td>
                                <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
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
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">Trước</span>
                            <span class="sr-only">Sau</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
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
</script>
@endsection
