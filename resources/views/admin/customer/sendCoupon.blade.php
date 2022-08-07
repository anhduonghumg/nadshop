<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <style>
        body {
            font-family: Arial;

        }

        .coupon {
            border: 5px dotted #bbb;
            width: 80%;
            border-radius: 15px;
            margin: 0 auto;
            max-width: 600px;

        }

        .container {
            padding: 2px 16px;
            background: #f1f1f1;
        }

        .promo {
            background: #ccc;
            padding: 3px;

        }

        .expire {
            color: red;
        }

        p.code {
            text-align: center;
            font-size: 20px;

        }

        p.expire {
            text-align: center;
        }

        h2.note {
            text-align: center;
            font-size: large;
            text-decoration: underline;
        }
    </style>
    <div class="coupon">
        <div class="container">
            <h4>Mã khuyến mãi từ <a target="_blank" href="http://localhost/nadshop/">NADSHOP</a></h4>
        </div>
        <div class="container" style="background-color:white">
            <h2 class="note">Giảm {{ currentcyFormat($data['value_coupon']) }} cho tất cả hóa đơn</h2>
            <p>Quý khách đã từng mua hàng tại shop <a target="_blank" href="http://localhost/nadshop/">NADSHOP</a>.Quý
                khách có thể truy vào shop nhập mã code phía dưới để được giảm giá mua hàng,xin cảm ơn quý khách.Chúc
                quý khách nhiều sức khỏe và bình an trong cuộc sống.</p>
        </div>
        <div class="container">
            <p class="code">Sử dụng Code sau: <strong class="promo">{{ $data['code_coupon'] }}</strong></p>
            <p class="expire">Số lượng mã giảm giá :{{ $data['qty_coupon'] }}</p>
        </div>
    </div>
</body>

</html>
