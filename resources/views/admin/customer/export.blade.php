<table class="table">
    <thead>
        <tr>
            <th>
                <input id="checkall" name="checkall" type="checkbox">
            </th>
            <th scope="col">STT</th>
            <th scope="col">Họ tên</th>
            <th scope="col">Email</th>
            <th scope="col">SĐT</th>
            <th scope="col">SP đã mua</th>
            <th scope="col">Đã tiêu</th>
        </tr>
    </thead>
    <tbody>
        @php $temp=0; @endphp
        @foreach ($customer as $item)
            @php $temp++ @endphp
            <tr>
                <td>
                    <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                </td>
                <td scope="row">{{ $temp }}</td>
                <td scope="row">{{ $item->fullname }}</td>
                <td scope="row">{{ $item->email }}</td>
                <td scope="row">{{ $item->phone }}</td>
                <td scope="row">{{ $item->total_order }}</td>
                <td scope="row">{{ currentcyFormat($item->total_spend) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
