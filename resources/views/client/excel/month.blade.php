<table class="table">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tháng</th>
            <th scope="col">Doanh số</th>
            <th scope="col">Lợi nhuận</th>
            <th scope="col">Tổng sản phẩm bán</th>
            <th scope="col">Tổng số đơn hàng</th>
        </tr>
    </thead>
    <tbody>
        @php $temp=0; @endphp
        @foreach ($sale as $item)
            @php $temp++ @endphp
            <tr>
                <td scope="row">{{ $temp }}</td>
                <td scope="row">{{ $item->month_order }}</td>
                <td scope="row">{{ currentcyFormat($item->sale) }}</td>
                <td scope="row">{{ currentcyFormat($item->profit) }}</td>
                <td scope="row">{{ $item->product_qty }}</td>
                <td scope="row">{{ $item->order_qty }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
