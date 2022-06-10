@extends('layouts.client')
@section('content')
<div class="breadcrumb-shop clearfix bg-none px-xl-5">
    <div class="clearfix">
        <div class="">
            <ol class="breadcrumb breadcrumb-arrows clearfix">
                <li><a href="{{ route('client.home') }}" target="_self"><i class="fa fa-home"></i>Trang chủ</a><i
                        class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                <li>Sản phẩm yêu thích</li>
            </ol>
        </div>
    </div>
</div>
<!-- Shop Start -->
<div class="container-fluid">
    <h3 class='px-xl-5 pb-3'>Sản phẩm yêu thích</h3>
    <div id="load_wishlist"></div>
</div>
<!-- Shop End -->
<script type="text/javascript">
    var output = `<div class="row px-xl-5 pb-3">`;
    if(localStorage.getItem('data_wishlist') != null){
       var data = JSON.parse(localStorage.getItem('data_wishlist'));
       $.each(data, function (key, value){
           var price = currencyFormat(value.price);
    output += `<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
    <div class="card product-item border-0 mb-4">
        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <img class="img-fluid w-100" src="${value.image}" alt="">
        </div>
        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <h6 class="text-truncate mb-3">${value.name}</h6>
            <div class="d-flex justify-content-center">
                <h6>${price}</h6>
                <h6 class="text-muted ml-2"><del>${price}</del></h6>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between bg-light border">
            <a href="${value.url}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                Detail</a>
            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
        </div>
    </div></div>`;
      });
    }else{
        output += `<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <p>Không có dữ liệu.</p>
        </div>`;
    }
    output += `</div>`;
    $('#load_wishlist').html(output);
</script>
@endsection
