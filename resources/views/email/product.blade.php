<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Đơn giá</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Thành tiền</th>
        </tr>
    </thead>
    @if ($list_product_order->isNotEmpty())
    @php $temp = 0; @endphp
    <tbody>
        @foreach ($list_product_order as $item)
        @php $temp++; @endphp
        <tr>
            <td scope="col">{{ $temp }}</td>
            <td scope="col"><img
                    src="{{ asset('storage/app/public/images/product/thumb/' . $item->product_details_thumb) }}"
                    width='80px' height="80px" alt=""></td>
            <td scope="col">{{ $item->product_detail_name }}</td>
            <td scope="col">
                {{ currentcyFormat($item->product_price - ($item->product_price * $item->product_discount) / 100) }}
            </td>
            <td scope="col">{{ $item->pro_order_qty }}</td>
            <td scope="col">
                {{ currentcyFormat($item->pro_order_qty * ($item->product_price - ($item->product_price *
                $item->product_discount) / 100)) }}
            </td>
        </tr>
        @endforeach
    </tbody>
    @endif
</table>
