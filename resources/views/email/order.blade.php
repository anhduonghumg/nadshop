<div class='container'>
    <h1>THÔNG TIN ĐƠN HÀNG</h1>
    <table class='info'>
        <tbody>
            <h3>Thông tin khách hàng</h3>
            <tr>
                <td>Mã đơn hàng</td>
                <td>{{$data['order_code']}}</td>
            </tr>
            <tr>
                <td>Tên</td>
                <td>{{$data['fullname']}}</td>
            </tr>
            <tr>
                <td>Số điện thoại</td>
                <td>{{$data['phone']}}</td>
            </tr>
            <tr>
                <td>Hình thức thanh toán</td>
                <td>{{$data['payment']}}</td>
            </tr>
        </tbody>
    </table>
    {!! $data['body'] !!}

    <p>Cảm ơn bạn đã tin tưởng mua hàng tại NADSHOP.com!</p>
    <p>Nếu bạn cần hỗ trợ vui lòng gọi <strong>0988669999</strong></p>
</div>
