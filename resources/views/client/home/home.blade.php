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
                    <h5 class="font-weight-semi-bold m-0">Ch???t l?????ng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Mi???n ph?? ship</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14 ng??y ?????i tr???</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">H??? tr??? 24/7</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">S???n ph???m m???i</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @if ($list_product_new->isNotEmpty())
                @foreach ($list_product_new as $product)
                    <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div
                                class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid" src="{{ asset($product->product_thumb) }}" alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">{{ $product->product_name }}</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>{{ currentcyFormat($product->product_price - ($product->product_price * $product->product_discount) / 100) }}
                                    </h6>
                                    <h6 class="text-muted ml-2">
                                        <del>{{ currentcyFormat($product->product_price) }}</del>
                                    </h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="{{ route('client.product.detail', $product->id) }}"
                                    data-id="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                    data-img="{{ $product->product_thumb }}"
                                    data-url="{{ route('client.product.detail', $product->id) }}"
                                    data-price="{{ $product->product_price - ($product->product_price * $product->product_discount) / 100 }}"
                                    class="btn btn-sm text-dark p-0 btn_view"><i
                                        class="fas fa-eye text-primary mr-1"></i>Xem chi ti???t</a>
                                <a class="btn btn-sm text-dark p-0 btn_buy_now" data-id="{{ $product->id }}"><i
                                        class="fas fa-shopping-cart text-primary mr-1"></i>Mua ngay</a>
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
            <h2 class="section-title px-5"><span class="px-2">S???n ph???m b??n ch???y</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @if ($list_product_best_sell->isNotEmpty())
                @foreach ($list_product_best_sell as $product2)
                    <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div
                                class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid" src="{{ asset($product2->product_thumb) }}" alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">{{ $product2->product_name }}</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>{{ currentcyFormat($product2->product_price - ($product2->product_price * $product2->product_discount) / 100) }}
                                    </h6>
                                    <h6 class="text-muted ml-2">
                                        <del>{{ currentcyFormat($product2->product_price) }}</del>
                                    </h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="{{ route('client.product.detail', $product2->id) }}"
                                    data-id="{{ $product2->id }}" data-name="{{ $product2->product_name }}"
                                    data-img="{{ $product2->product_thumb }}"
                                    data-url="{{ route('client.product.detail', $product2->id) }}"
                                    data-price="{{ $product2->product_price - ($product2->product_price * $product2->product_discount) / 100 }}"
                                    class="btn btn-sm text-dark p-0 btn_view"><i
                                        class="fas fa-eye text-primary mr-1"></i>Xem chi ti???t</a>
                                <a class="btn btn-sm text-dark p-0 btn_buy_now" data-id="{{ $product2->id }}"><i
                                        class="fas fa-shopping-cart text-primary mr-1"></i>Mua
                                    ngay</a>
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
            <h2 class="section-title "><span class="text-uppercase">??o Nam</span></h2>
            <div class="outerTabTitle">
                <ul class="tabTitle d-flex">
                    @foreach ($list_menu_shirt as $menu)
                        <li class="titleTabItem active">
                            <a class="tp_title text-uppercase"
                                data-id={{ $menu->id }}>{{ $menu->category_product_name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row px-xl-5 pb-3 load_data">
            {{-- @if ($list_shirt != null) --}}
            @foreach ($list_shirt as $shirt)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid" src="{{ asset($shirt->product_thumb) }}" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $shirt->product_name }}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>{{ currentcyFormat($shirt->product_price) }}</h6>
                                <h6 class="text-muted ml-2"><del>{{ currentcyFormat($product->product_price) }}</del>
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{ route('client.product.detail', $shirt->id) }}" data-id="{{ $shirt->id }}"
                                data-name="{{ $shirt->product_name }}" data-img="{{ $shirt->product_thumb }}"
                                data-url="{{ route('client.product.detail', $shirt->id) }}"
                                data-price="{{ $shirt->product_price }}" class="btn btn-sm text-dark p-0 btn_view"><i
                                    class="fas fa-eye text-primary mr-1"></i>Xem chi ti???t</a>
                            <a class="btn btn-sm text-dark p-0 btn_buy_now" data-id="{{ $shirt->id }}"><i
                                    class="fas fa-shopping-cart text-primary mr-1"></i>Mua ngay</a>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- @endif --}}
        </div>
    </div>
    <!-- Products End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="ml-5 mb-5 d-flex">
            <h2 class="section-title "><span class="text-uppercase">Qu???n Nam</span></h2>
            <div class="outerTabTitle">
                <ul class="tabTitle d-flex">
                    @foreach ($list_menu_trousers as $menu)
                        <li class="titleTabItem active">
                            <a class="trouser_title text-uppercase"
                                data-id={{ $menu->id }}>{{ $menu->category_product_name }}</a>
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
            <h2 class="section-title "><span class="text-uppercase">Ph??? ki???n</span></h2>
            <div class="outerTabTitle">
                <ul class="tabTitle d-flex">
                    @foreach ($list_menu_accessories as $menu)
                        <li class="titleTabItem active">
                            <a class="accessory_title text-uppercase"
                                data-id={{ $menu->id }}>{{ $menu->category_product_name }}</a>
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

    <!-- Modal buy now start-->
    <div class="show-modal-cart-buy">

    </div>
    <!-- Modal buy now end-->

    <!-- Modal Account Start -->
    <div class="modal fade login" id="loginModal">
        <div class="modal-dialog login animated">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>????ng nh???p v???i</h5>
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
                                <span>Ho???c</span>
                                <div class="line r"></div>
                            </div>
                            <div class="error"></div>
                            <div class="form loginBox">
                                <form method="" action="">
                                    <input id="username" class="form-control" type="text"
                                        placeholder="T??n ????ng nh???p" name="password">
                                    <input id="password" class="form-control" type="password" placeholder="M???t kh???u"
                                        name="password">
                                    <input class="btn btn-default btn-login" type="button" value="????ng nh???p">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="content registerBox" style="display:none;">
                            <div class="form">
                                <form method="" html="{:multipart=>true}" data-remote="true" action=""
                                    accept-charset="UTF-8">
                                    <input id="email" class="form-control" type="text" placeholder="Email"
                                        name="email">
                                    <input id="password" class="form-control" type="password" placeholder="Password"
                                        name="password">
                                    <input id="password_confirmation" class="form-control" type="password"
                                        placeholder="Repeat Password" name="password_confirmation">
                                    <input class="btn btn-default btn-register" type="button" value="T???o t??i kho???n"
                                        name="commit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="forgot login-footer">
                        <span><a href="" class='register'>T???o m???t t??i kho???n</a>?</span>
                    </div>
                    <div class="forgot register-footer" style="display:none">
                        <span>B???n ???? c?? t??i kho???n?</span>
                        <a href="javascript: showLoginForm();">????ng nh???p</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Account End -->

    <script type="text/javascript">
        var is_busy = false;
        $(document).on('click', '.account', function(e) {
            e.preventDefault();
            openLoginModal();
        });

        $(document).on('click', '.register', function(e) {
            e.preventDefault();
            openRegisterModal();
        });

        $(document).on('click', '.tp_title', function(e) {
            e.preventDefault();
            if (is_busy == true) {
                return false;
            }
            var data = $(this).attr('data-id');
            var selector = $('.load_data');
            load_data(selector, data);
        });

        $(document).on('click', '.trouser_title', function(e) {
            e.preventDefault();
            if (is_busy == true) {
                return false;
            }
            var data = $(this).attr('data-id');
            var selector = $('.load_trouser_data');
            load_data(selector, data);
        });

        $(document).on('click', '.accessory_title', function(e) {
            e.preventDefault();
            if (is_busy == true) {
                return false;
            }
            var data = $(this).attr('data-id');
            var selector = $('.load_accessory_data');
            load_data(selector, data);
        });

        $('body').on('click', '.btn_buy_now', buy_now);

        $('body').on('click', '.btn_color', color_check);

        $('body').on('click', '.btn_size', function(e) {
            let check_color = $('.color_check').is(':checked');
            if (check_color == false) {
                e.preventDefault();
                alert('B???n ph???i ch???n m??u s???c tr?????c');
            }
            return true;
        });

        $('body').on('click', '#buy_now', function(e) {
            let check_color = $('.color_check').is(':checked');
            let check_size = $('.size-check').is(':checked');
            if (check_color == false || check_size == false) {
                e.preventDefault();
                alert('B???n ch??a ch???n m??u ho???c ch??a ch???n k??ch c???');
            } else {
                if (is_busy) return false;
                let product_id = $(this).data('product');
                let product_variant = $(this).data('variant');
                let qty = Number($('.popup_quantity').val());
                is_busy = true;
                $.ajax({
                    url: "{{ route('client.cart.add') }}",
                    type: "POST",
                    data: {
                        product_id: product_id,
                        product_variant: product_variant
                    },
                    dataType: "json",
                    success: function(rsp) {
                        let name = rsp.product_detail_name;
                        let price = rsp.product_price - (rsp.product_price * rsp.product_discount /
                            100);
                        let thumbnail = rsp.product_details_thumb;
                        let cost_price = rsp.cost_price;
                        let newCart = {
                            'id': product_variant,
                            'name': name,
                            'price': price,
                            'cost_price': cost_price,
                            'thumbnail': thumbnail,
                            'qty': qty,
                        }

                        if (localStorage.getItem('data_cart') == null) {
                            localStorage.setItem('data_cart', '[]');
                        }

                        let old_cart_data = JSON.parse(localStorage.getItem('data_cart'));
                        const itemExist = old_cart_data.find(item => {
                            if (item.id === product_variant) {
                                item.qty += qty;
                                return true;
                            }
                            return false;
                        })

                        if (!itemExist) {
                            old_cart_data.push(newCart);
                        }
                        localStorage.setItem('data_cart', JSON.stringify(old_cart_data));
                        num_in_cart();
                        openCart();
                        is_busy = false;
                    },
                    error: function() {
                        alert("error!!!!");
                    }
                });
            }
        });

        $('body').on('click', '#size_check', size_check);


        function buy_now(e) {
            e.preventDefault();
            if (is_busy == true) {
                return false;
            }
            let id = $(this).attr('data-id');
            is_busy = true;
            $.ajax({
                url: "{{ route('client.cart.buy') }}",
                type: 'POST',
                data: {
                    id: id
                },
                dataType: "json",
                success: function(rsp) {
                    let product = rsp.product;
                    let colors = rsp.list_colors;
                    let html = render_buy_now(product, colors);
                    $('.show-modal-cart-buy').html(html);
                    $('#modal_cart').modal('show');
                    is_busy = false;
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function render_buy_now(data, data2) {
            let output = `<div class="modal fade" id="modal_cart" tabindex="-1" aria-hidden="true" data-backdrop=false>
                   <div class="modal-dialog modal-xl">
                       <div class="modal-content">
                          <div class="modal-body">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-lg-8 pb-5 px-xl-5">
                            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner border">
                                    <div class="carousel-item active">
                                        <img height="1000px" class="w-100" src="http://localhost/nadshop/${data.product_thumb}" alt="Image">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                                </a>
                                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 pb-5">
                            <h3 class="font-weight-semi-bold">${data.product_name}</h3>
                            <div class="mb-3">
                                <strong class="pt-1">C??n h??ng</strong>
                            </div>
                            <h3 class="font-weight-semi-bold mb-4">${currencyFormat(data.product_price - (data.product_price * data.product_discount / 100))}</h3>
                            <div class="mb-4">
                                <div class="info-color d-flex">
                                    <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">M??u s???c:</p>
                                    <span class="color-name"></span>
                                </div>`;
            output += `<div class="my-2">`;
            $.each(data2, function(key, value) {
                output += `<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="color_check" name="color" id="color_${value.id}"
                                autocomplete="off">
                            <label class="color-label btn_color" data-color="${value.id}" data-id="${value.proId}" data-toggle="tooltip"
                                title="${value.color_name}" style="background-color:${value.code_color}" for="color_${value.id}">
                                <i class="fas fa-check icon-color"></i>
                            </label>
                          </div>`;
            });
            output += `</div>
                            </div>
                            <div class="mb-3">
                                <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">K??ch th?????c:</p>
                                <div class="my-2" id="variant_size">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="size-check" name="size" id="btn_size1"
                                            autocomplete="off">
                                        <label class="btn btn-outline-dark btn_size" data-toggle="tooltip"
                                            for="btn_size1">S</label>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="size-check" name="size" id="btn_size2"
                                            autocomplete="off">
                                        <label class="btn btn-outline-dark btn_size" data-toggle="tooltip"
                                            for="btn_size2">M</label>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="size-check" name="size" id="btn_size3"
                                            autocomplete="off">
                                        <label class="btn btn-outline-dark btn_size" data-toggle="tooltip"
                                            for="btn_size3">L</label>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="size-check" name="size" id="btn_size4"
                                            autocomplete="off">
                                        <label class="btn btn-outline-dark btn_size" data-toggle="tooltip"
                                            for="btn_size4">XL</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2" id="variant_qty">
                            </div>
                            <div class="d-flex align-items-center mb-4 pt-2">
                                <div class="input-group quantity mr-3" style="width: 130px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-minus">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control bg-secondary text-center popup_quantity"
                                        value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="select-action">
                                <div class="d-flex btn_buy">
                                    <button class="btn btn-dark px-3 mr-2" id="buy_now">S??? h???u ngay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
            return output;
        }

        function color_check() {
            if (is_busy) return false;
            let id_color = $(this).attr('data-color');
            let id_product = $(this).attr('data-id');
            is_busy = true;
            $.ajax({
                url: "{{ route('client.product.variant') }}",
                type: "POST",
                data: {
                    id_color: id_color,
                    id_product: id_product
                },
                dataType: "json",
                success: function(rsp) {
                    //$('.loading').hide();
                    let show_size = color_check_render(rsp.size);
                    $('.color-name').html(rsp.color_name);
                    $('#variant_size').html(show_size);
                    is_busy = false;
                },
                error: function() {
                    //$(".loading").hide();
                    alert("error!!!!");
                }
            });
        }

        function color_check_render(data) {
            var output = '';
            if (data.length > 0) {
                $.each(data, function(key, value) {
                    output += `<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="size-check" name="size" id="size_${value.id}" autocomplete="off">
                <label id="size_check" class="btn btn-outline-dark btn_size" data-pro="${value.proId}" data-id="${value.pId}" for="size_${value.id}">${value.size_name}</label>
            </div>`;
                });
                //output += `<p class="text-dark font-weight-medium mb-0 mr-3 mb-2">S??? l?????ng c??n l???i: ${value.product_qty_stock}</p>`;
            } else {
                output += `<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Phi??n b???n n??y kh??ng c??n</p>
        </div>`;
            }
            return output;
        }

        function size_check() {
            if (is_busy) return false;
            if ($("input[name='color']:checked").val()) {
                let product_variant = $(this).data('pro');
                let product = $(this).attr('data-id');
                is_busy = true;
                $.ajax({
                    url: "{{ route('client.product.change') }}",
                    type: "POST",
                    data: {
                        product_variant: product_variant,
                        product: product
                    },
                    dataType: "json",
                    success: function(rsp) {
                        let show = render_button(rsp.variant_id, rsp.pro_id);
                        $('.btn_buy').html(show);
                        is_busy = false;
                    },
                    error: function() {
                        alert("error!!!!");
                    }
                });
            } else {
                alert('B???n ch??a ch???n m??u');
            }
        }

        function render_button(data, data2) {
            var output = ''
            output +=
                `<button class="btn btn-dark px-3 mr-2" id="buy_now" data-variant="${data}" data-product="${data2}">S??? h???u ngay</button>`
            return output;
        }

        function load_data(selector, data) {
            $(".loading").show();
            is_busy = true;
            $.ajax({
                url: "{{ route('client.product.load') }}",
                type: "POST",
                data: {
                    id: data
                },
                dataType: "html",
                success: function(rsp) {
                    $(".loading").hide();
                    selector.html(rsp);
                    is_busy = false;
                },
                error: function() {
                    $(".loading").hide();
                    alert("error!!!!");
                },
            });
        }


        function openLoginModal() {
            showLoginForm();
            setTimeout(function() {
                $('#loginModal').modal('show');
            }, 230);
        }

        function openRegisterModal() {
            showRegisterForm();
            setTimeout(function() {
                $('#loginModal').modal('show');
            }, 230);

        }

        function showLoginForm() {
            $('#loginModal .registerBox').fadeOut('fast', function() {
                $('.loginBox').fadeIn('fast');
                $('.register-footer').fadeOut('fast', function() {
                    $('.login-footer').fadeIn('fast');
                });
                $('.modal-title').html('Login with');
            });
            $('.error').removeClass('alert alert-danger').html('');
        }

        function showRegisterForm() {
            $('.loginBox').fadeOut('fast', function() {
                $('.registerBox').fadeIn('fast');
                $('.login-footer').fadeOut('fast', function() {
                    $('.register-footer').fadeIn('fast');
                });
                $('.modal-title').html('Register with');
            });
            $('.error').removeClass('alert alert-danger').html('');
        }
    </script>
@endsection
