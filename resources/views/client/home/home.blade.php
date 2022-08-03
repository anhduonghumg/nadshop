@extends('layouts.client')
@section('carousel')
    <style>
        .list-inline {
            display: flex;
        }

        ul li a {
            color: black;
        }
    </style>
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
                                <a href="{{ route('client.product.detail', $product->id) }}" data-id="{{ $product->id }}"
                                    data-name="{{ $product->product_name }}" data-img="{{ $product->product_thumb }}"
                                    data-url="{{ route('client.product.detail', $product->id) }}"
                                    data-price="{{ $product->product_price - ($product->product_price * $product->product_discount) / 100 }}"
                                    class="btn btn-sm text-dark p-0 btn_view"><i
                                        class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
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
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm bán chạy</span></h2>
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
                                        class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
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
            <h2 class="section-title "><span class="text-uppercase">Áo Nam</span></h2>
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
                                <h6>{{ currentcyFormat($shirt->product_price - ($shirt->product_price * $shirt->product_discount) / 100) }}
                                </h6>
                                <h6 class="text-muted ml-2"><del>{{ currentcyFormat($shirt->product_price) }}</del>
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{ route('client.product.detail', $shirt->id) }}" data-id="{{ $shirt->id }}"
                                data-name="{{ $shirt->product_name }}" data-img="{{ $shirt->product_thumb }}"
                                data-url="{{ route('client.product.detail', $shirt->id) }}"
                                data-price="{{ $shirt->product_price - ($shirt->product_price * $shirt->product_discount) / 100 }}"
                                class="btn btn-sm text-dark p-0 btn_view"><i class="fas fa-eye text-primary mr-1"></i>Xem
                                chi tiết</a>
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
            <h2 class="section-title "><span class="text-uppercase">Quần Nam</span></h2>
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
            @foreach ($list_trousers as $trouser)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid" src="{{ asset($trouser->product_thumb) }}" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $trouser->product_name }}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>{{ currentcyFormat($trouser->product_price - ($trouser->product_price * $trouser->product_discount) / 100) }}
                                </h6>
                                <h6 class="text-muted ml-2"><del>{{ currentcyFormat($trouser->product_price) }}</del>
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{ route('client.product.detail', $trouser->id) }}" data-id="{{ $trouser->id }}"
                                data-name="{{ $trouser->product_name }}" data-img="{{ $trouser->product_thumb }}"
                                data-url="{{ route('client.product.detail', $trouser->id) }}"
                                data-price="{{ $trouser->product_price - ($trouser->product_price * $trouser->product_discount) / 100 }}"
                                class="btn btn-sm text-dark p-0 btn_view"><i class="fas fa-eye text-primary mr-1"></i>Xem
                                chi tiết</a>
                            <a class="btn btn-sm text-dark p-0 btn_buy_now" data-id="{{ $trouser->id }}"><i
                                    class="fas fa-shopping-cart text-primary mr-1"></i>Mua ngay</a>
                        </div>
                    </div>
                </div>
            @endforeach
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
                            <a class="accessory_title text-uppercase"
                                data-id={{ $menu->id }}>{{ $menu->category_product_name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row px-xl-5 pb-3 load_accessory_data">
            @foreach ($list_accessories as $accessorie)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid" src="{{ asset($accessorie->product_thumb) }}" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $accessorie->product_name }}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>{{ currentcyFormat($accessorie->product_price - ($accessorie->product_price * $accessorie->product_discount) / 100) }}
                                </h6>
                                <h6 class="text-muted ml-2"><del>{{ currentcyFormat($accessorie->product_price) }}</del>
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{ route('client.product.detail', $accessorie->id) }}"
                                data-id="{{ $accessorie->id }}" data-name="{{ $accessorie->product_name }}"
                                data-img="{{ $accessorie->product_thumb }}"
                                data-url="{{ route('client.product.detail', $accessorie->id) }}"
                                data-price="{{ $accessorie->product_price - ($accessorie->product_price * $accessorie->product_discount) / 100 }}"
                                class="btn btn-sm text-dark p-0 btn_view"><i class="fas fa-eye text-primary mr-1"></i>Xem
                                chi tiết</a>
                            <a class="btn btn-sm text-dark p-0 btn_buy_now" data-id="{{ $accessorie->id }}"><i
                                    class="fas fa-shopping-cart text-primary mr-1"></i>Mua ngay</a>
                        </div>
                    </div>
                </div>
            @endforeach
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


    <script type="text/javascript">
        var is_busy = false;


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
                alert('Bạn phải chọn màu sắc trước');
            }
            return true;
        });

        $('body').on('click', '#buy_now', function(e) {
            let check_color = $('.color_check').is(':checked');
            let check_size = $('.size-check').is(':checked');
            if (check_color == false || check_size == false) {
                e.preventDefault();
                alert('Bạn chưa chọn màu hoặc chưa chọn kích cỡ');
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
                    let rating = rsp.rating;
                    let count_rating = rsp.count_rating;
                    let html = render_buy_now(product, colors, rating, count_rating);
                    $('.show-modal-cart-buy').html(html);
                    $('#modal_cart').modal('show');
                    is_busy = false;
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function render_buy_now(data, data2, data3, data4) {
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
                           <ul style="margin: 0px" class="list-inline" title="average rating">`;
            for (let count = 1; count <= 5; count++) {
                if (count <= data3) {
                    var color = 'color:#ffcc00;';
                } else {
                    var color = 'color:#ccc;';
                }

                output += `<li style="${color};font-size:20px;margin-right:10px;">
                            &#9733;
                        </li>`;
            }
            if (data4 > 0) {
                output += `<p style="font-size:13px;margin-top:5px">${data4} đánh giá</p>`;
            } else {
                output += `<p style="font-size:13px;margin-top:5px">chưa có đánh giá</p>`;
            }
            output += `</ul>`;
            output += `<div class="mb-3">
                                <strong class="pt-1">Còn hàng</strong>
                            </div>
                            <h3 class="font-weight-semi-bold mb-4">${currencyFormat(data.product_price - (data.product_price * data.product_discount / 100))}</h3>
                            <div class="mb-4">
                                <div class="info-color d-flex">
                                    <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Màu sắc:</p>
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
                                <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Kích thước:</p>
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
                                    <button class="btn btn-dark px-3 mr-2" id="buy_now">Sỡ hữu ngay</button>
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
                //output += `<p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Số lượng còn lại: ${value.product_qty_stock}</p>`;
            } else {
                output += `<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Phiên bản này không còn</p>
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
                alert('Bạn chưa chọn màu');
            }
        }

        function render_button(data, data2) {
            var output = ''
            output +=
                `<button class="btn btn-dark px-3 mr-2" id="buy_now" data-variant="${data}" data-product="${data2}">Sỡ hữu ngay</button>`
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
    </script>
@endsection
