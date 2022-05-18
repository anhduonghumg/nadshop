<div class="analytic">
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
        <select class="form-control mr-1" name="act" id="act">
            <option value="">Chọn</option>
            @foreach ($list_action as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary mr-3">
        <a href="{{ route('admin.order.add') }}" class="btn btn-success btn-rounded btn-add"><i class="fa fa-plus"></i>
            Thêm
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
                    <input class="check_order" type="checkbox" name="list_check[]" value="{{ $order['id'] }}">
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
    {{ $list_orders->links('layouts.paginationlink') }}
