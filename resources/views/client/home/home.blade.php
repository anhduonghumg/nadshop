@extends('layouts.client')
@section('carousel')
<div class="carousel-inner">
    <div class="carousel-item active" style="height: 410px;">
        <img class="img-fluid" src="{{ url('public/client/img/carousel-1.jpg') }}" alt="Image">
        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
            <div class="p-3" style="max-width: 700px;">
                <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>
                <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
            </div>
        </div>
    </div>
    <div class="carousel-item" style="height: 410px;">
        <img class="img-fluid" src="{{ url('public/client/img/carousel-2.jpg') }}" alt="Image">
        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
            <div class="p-3" style="max-width: 700px;">
                <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First
                    Order</h4>
                <h3 class="display-4 text-white font-weight-semi-bold mb-4">Reasonable Price</h3>
                <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
            </div>
        </div>
    </div>
</div>
<a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
    <div class="btn btn-dark" style="width: 45px; height: 45px;">
        <span class="carousel-control-prev-icon mb-n2"></span>
    </div>
</a>
<a class="carousel-control-next" href="#header-carousel" data-slide="next">
    <div class="btn btn-dark" style="width: 45px; height: 45px;">
        <span class="carousel-control-next-icon mb-n2"></span>
    </div>
</a>
@endsection
@section('content')
<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Chất lượng</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Miễn phí ship</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">14 ngày đổi trả</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Hỗ trợ 24/7</h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Sản phẩm mới</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @if($list_product_new->isNotEmpty())
        @foreach ($list_product_new as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid" src="{{ asset($product->product_thumb) }}" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{ $product->product_name }}</h6>
                    <div class="d-flex justify-content-center">
                        <h6>{{ currentcyFormat($product->product_price) }}</h6>
                        <h6 class="text-muted ml-2"><del>{{ currentcyFormat($product->product_price ) }}</del>
                        </h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{ route('client.product.cat.show',$product->id) }}" class="btn btn-sm text-dark p-0"><i
                            class="fas fa-eye text-primary mr-1"></i>View
                        Detail</a>
                    <a href="" class="btn btn-sm text-dark p-0"><i
                            class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
<!-- Products End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Sản phẩm bán chạy</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @if($list_product_best_sell->isNotEmpty())
        @foreach ($list_product_best_sell as $product2)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid" src="{{ asset($product2->product_thumb) }}" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{ $product2->product_name }}</h6>
                    <div class="d-flex justify-content-center">
                        <h6>{{ currentcyFormat($product2->product_price) }}</h6>
                        <h6 class="text-muted ml-2"><del>{{ currentcyFormat($product2->product_price) }}</del></h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{ route('client.product.detail',$product2->id) }}" class="btn btn-sm text-dark p-0"><i
                            class="fas fa-eye text-primary mr-1"></i>View
                        Detail</a>
                    <a href="" class="btn btn-sm text-dark p-0"><i
                            class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
<!-- Products End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="ml-5 mb-5 d-flex">
        <h2 class="section-title "><span class="text-uppercase">Áo Nam</span></h2>
        <div class="outerTabTitle">
            <ul class="tabTitle d-flex">
                @foreach ($list_menu_shirt as $menu)
                <li class="titleTabItem active">
                    <a class="tp_title text-uppercase" data-id={{ $menu->id }}>{{ $menu->category_product_name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row px-xl-5 pb-3 load_data">
        {{-- @if($list_product_best_sell->isNotEmpty())
        @foreach ($list_product_best_sell as $product2)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid" src="{{ asset($product2->product_thumb) }}" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{ $product2->product_name }}</h6>
                    <div class="d-flex justify-content-center">
                        <h6>{{ currentcyFormat($product2->product_price) }}</h6>
                        <h6 class="text-muted ml-2"><del>{{ currentcyFormat($product2->product_price) }}</del></h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{ route('client.product.detail',$product2->id) }}" class="btn btn-sm text-dark p-0"><i
                            class="fas fa-eye text-primary mr-1"></i>View
                        Detail</a>
                    <a href="" class="btn btn-sm text-dark p-0"><i
                            class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                </div>
            </div>
        </div>
        @endforeach
        @endif --}}
    </div>
</div>
<!-- Products End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="ml-5 mb-5 d-flex">
        <h2 class="section-title "><span class="text-uppercase">Quần Nam</span></h2>
        <div class="outerTabTitle">
            <ul class="tabTitle d-flex">
                @foreach ($list_menu_trousers as $menu)
                <li class="titleTabItem active">
                    <a class="trouser_title text-uppercase" data-id={{ $menu->id }}>{{ $menu->category_product_name
                        }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row px-xl-5 pb-3 load_trouser_data">

    </div>
</div>
<!-- Products End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="ml-5 mb-5 d-flex">
        <h2 class="section-title "><span class="text-uppercase">Phụ kiện</span></h2>
        <div class="outerTabTitle">
            <ul class="tabTitle d-flex">
                @foreach ($list_menu_accessories as $menu)
                <li class="titleTabItem active">
                    <a class="accessory_title text-uppercase" data-id={{ $menu->id }}>{{ $menu->category_product_name
                        }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row px-xl-5 pb-3 load_accessory_data">

    </div>
</div>
<!-- Products End -->

<!-- Vendor Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel vendor-carousel">
                <div class="vendor-item border p-4">
                    <img src="{{ url('public/client/img/vendor-1.jpg') }}" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="{{ url('public/client/img/vendor-2.jpg') }}" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="{{ url('public/client/img/vendor-3.jpg') }}" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="{{ url('public/client/img/vendor-4.jpg') }}" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="{{ url('public/client/img/vendor-5.jpg') }}" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="{{ url('public/client/img/vendor-6.jpg') }}" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="{{ url('public/client/img/vendor-7.jpg') }}" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="{{ url('public/client/img/vendor-8.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vendor End -->

<!-- Modal Account Start -->
<div class="modal fade login" id="loginModal">
    <div class="modal-dialog login animated">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Đăng nhập với</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="box">
                    <div class="content">
                        <div class="social">
                            {{-- <a class="circle github" href="#">
                                <i class="fa fa-github fa-fw"></i>
                            </a> --}}
                            <a id="google_login" class="circle google" href="#">
                                <i class="fab fa-google"></i>
                            </a>
                            <a id="facebook_login" class="circle facebook" href="#">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </div>
                        <div class="division">
                            <div class="line l"></div>
                            <span>Hoặc</span>
                            <div class="line r"></div>
                        </div>
                        <div class="error"></div>
                        <div class="form loginBox">
                            <form method="" action="">
                                <input id="username" class="form-control" type="text" placeholder="Tên đăng nhập"
                                    name="password">
                                <input id="password" class="form-control" type="password" placeholder="Mật khẩu"
                                    name="password">
                                <input class="btn btn-default btn-login" type="button" value="Đăng nhập">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="content registerBox" style="display:none;">
                        <div class="form">
                            <form method="" html="{:multipart=>true}" data-remote="true" action=""
                                accept-charset="UTF-8">
                                <input id="email" class="form-control" type="text" placeholder="Email" name="email">
                                <input id="password" class="form-control" type="password" placeholder="Password"
                                    name="password">
                                <input id="password_confirmation" class="form-control" type="password"
                                    placeholder="Repeat Password" name="password_confirmation">
                                <input class="btn btn-default btn-register" type="button" value="Tạo tài khoản"
                                    name="commit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="forgot login-footer">
                    <span><a href="" class='register'>Tạo một tài khoản</a>?</span>
                </div>
                <div class="forgot register-footer" style="display:none">
                    <span>Bạn đã có tài khoản?</span>
                    <a href="javascript: showLoginForm();">Đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Account End -->

<script type="text/javascript">
    var is_busy = false;
    $(document).on('click','.account',function(e){
        e.preventDefault();
        openLoginModal();
    });

    $(document).on('click','.register',function(e){
        e.preventDefault();
        openRegisterModal();
    });

    $(document).on('click','.tp_title',function(e){
        e.preventDefault();
        if (is_busy == true) {
            return false;
        }
        var data = $(this).attr('data-id');
        var selector = $('.load_data');
        load_data(selector,data);
    })

    $(document).on('click','.trouser_title',function(e){
        e.preventDefault();
        if (is_busy == true) {
            return false;
        }
        var data = $(this).attr('data-id');
        var selector = $('.load_trouser_data');
        load_data(selector,data);
    })

    $(document).on('click','.accessory_title',function(e){
        e.preventDefault();
        if (is_busy == true) {
            return false;
        }
        var data = $(this).attr('data-id');
        var selector = $('.load_accessory_data');
        load_data(selector,data);
    })

    function load_data(selector,data){
        $(".loading").show();
        is_busy = true;
        $.ajax({
            url: "{{ route('client.product.load') }}",
            type: "POST",
            data: {id:data},
            dataType: "html",
            success: function (rsp) {
             $(".loading").hide();
             selector.html(rsp);
             is_busy = false;
            },error: function () {
            $(".loading").hide();
             alert("error!!!!");
            },
        });
    }

function openLoginModal(){
    showLoginForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);
}

function openRegisterModal() {
    showRegisterForm();
    setTimeout(function () {
        $('#loginModal').modal('show');
    }, 230);

}

function showLoginForm(){
    $('#loginModal .registerBox').fadeOut('fast', function () {
        $('.loginBox').fadeIn('fast');
        $('.register-footer').fadeOut('fast', function () {
            $('.login-footer').fadeIn('fast');
        });
        $('.modal-title').html('Login with');
    });
    $('.error').removeClass('alert alert-danger').html('');
}

function showRegisterForm(){
    $('.loginBox').fadeOut('fast', function () {
        $('.registerBox').fadeIn('fast');
        $('.login-footer').fadeOut('fast', function () {
            $('.register-footer').fadeIn('fast');
        });
        $('.modal-title').html('Register with');
    });
    $('.error').removeClass('alert alert-danger').html('');
}
</script>
@endsection
