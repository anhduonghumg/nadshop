@extends('layouts.client')
@section('content')
    <style>
        .media {
            border: 1px solid black;
            border-radius: 22px;
            padding: 10px 8px;
        }

        .list-inline {
            display: flex;
        }
    </style>
    <div class="breadcrumb-shop clearfix px-xl-5 bg-none">
        <div class="padding-lf-40 clearfix">
            <div class="">
                <ol class="breadcrumb breadcrumb-arrows clearfix">
                    <li><a href="{{ route('client.home') }}" target="_self"><i class="fa fa-home"></i>Trang chủ</a><i
                            class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                    <li><a href="{{ route('client.product.cat.show', $product->product_cat_id) }}"
                            target="_self">{{ $product->category->category_product_name }}</a><i
                            class="fas fa-angle-double-right breadcrumb-icon"></i>
                    </li>
                    <li>{{ $product->product_name }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-7 pb-5 px-xl-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <img height="1000px" class="w-100" src="{{ asset($product->product_thumb) }}" alt="Image">
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
            <div class="col-5 pb-5">
                <h3 class="font-weight-semi-bold">{{ $product->product_name }}</h3>
                <ul style="margin: 0px" class="list-inline" title="average rating">
                    @for ($count = 1; $count <= 5; $count++)
                        @php
                            if ($count <= $rating) {
                                $color = 'color:#ffcc00;';
                            } else {
                                $color = 'color:#ccc;';
                            }
                        @endphp
                        <li style="{{ $color }};font-size:20px;margin-right:10px;">
                            &#9733;
                        </li>
                    @endfor
                    @if ($count_rating > 0)
                        <p style="font-size:13px;margin-top:5px">{{ $count_rating }} đánh giá</p>
                    @else
                        <p style="font-size:13px;margin-top:5px">chưa có đánh giá</p>
                    @endif
                </ul>
                <div class="mb-3">
                    <strong class="pt-1">Còn hàng</strong>
                </div>
                <h3 class="font-weight-semi-bold mb-4">
                    {{ currentcyFormat($product->product_price - ($product->product_price * $product->product_discount) / 100) }}
                </h3>
                <div class="mb-4">
                    <div class="info-color d-flex">
                        <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Màu sắc:</p>
                        <span class="color-name"></span>
                    </div>
                    <div class="my-2">
                        @if ($list_colors->isNotEmpty())
                            @foreach ($list_colors as $color)
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="color_check" name="color"
                                        id="btn_color{{ $color->id }}" autocomplete="off">
                                    <label class="color-label btn_color" data-color="{{ $color->id }}"
                                        data-id="{{ $color->proId }}" data-toggle="tooltip"
                                        title="{{ $color->color_name }}" style="background-color:{{ $color->code_color }}"
                                        for="btn_color{{ $color->id }}">
                                        <i class="fas fa-check icon-color"></i>
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Kích thước:</p>
                    <div class="my-2" id="variant_size">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="size-check" name="size" id="btn_size1" autocomplete="off">
                            <label class="btn btn-outline-dark btn_size" data-toggle="tooltip" for="btn_size1">S</label>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="size-check" name="size" id="btn_size2" autocomplete="off">
                            <label class="btn btn-outline-dark btn_size" data-toggle="tooltip" for="btn_size2">M</label>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="size-check" name="size" id="btn_size3" autocomplete="off">
                            <label class="btn btn-outline-dark btn_size" data-toggle="tooltip" for="btn_size3">L</label>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="size-check" name="size" id="btn_size4" autocomplete="off">
                            <label class="btn btn-outline-dark btn_size" data-toggle="tooltip" for="btn_size4">XL</label>
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
                        <input type="text" class="form-control bg-secondary text-center product_quantity"
                            value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="select-action">
                    <div class="d-flex btn_action">
                        <button class="btn btn-dark px-3 mr-2" id="add_to_cart">Thêm vào giỏ hàng</button>
                        <button class="btn btn-dark px-3 mr-2" id="buy_now">Mua ngay</button>
                    </div>
                    <div class="d-inline-flex mt-2">
                        <button class="btn btn-dark px-5" id="wishlist" data-name="{{ $product->product_name }}"
                            data-price="{{ $product->product_price - ($product->product_price * $product->product_discount) / 100 }}"
                            data-image="{{ asset($product->product_thumb) }}"
                            data-url="{{ route('client.product.detail', $pro_id) }}" data-id={{ $pro_id }}><i
                                class="far fa-heart mr-2"></i>Yêu
                            thích</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô tả sản phẩm</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Chính sách cửa hàng</a>
                    <a class="nav-item nav-link comment_rate" data-toggle="tab" href="#tab-pane-3">Đánh giá</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Mô tả</h4>
                        <div class="content-des">
                            {{ $product->product_desc }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Chính sách</h4>
                        <div class="description-content" style="display: block;">
                            <div class="description-productdetail">
                                <div class="description-productdetail">
                                    <p style="margin:10px 0px;padding:0px;list-style:none;"><span
                                            style="font-size:14px;"><span
                                                style="font-family:arial, helvetica, sans-serif;">&nbsp;►Đổi
                                                hàng&nbsp;trong
                                                vòng 5&nbsp;ngày.</span></span></p>
                                    <p style="margin:10px 0px;padding:0px;list-style:none;"><span
                                            style="font-size:14px;"><span
                                                style="font-family:arial, helvetica, sans-serif;">&nbsp;►Giảm đến 15% trên
                                                tổng hóa đơn khi mua hàng ( tại cửa hàng ) vào tháng sinh
                                                nhật.</span></span></p>
                                    <p style="margin:10px 0px;padding:0px;list-style:none;"><span
                                            style="font-size:14px;"><span
                                                style="font-family:arial, helvetica, sans-serif;">&nbsp;►Giao hàng nội
                                                thành
                                                Hà Nội chỉ từ 15.000đ trong vòng 24 giờ.</span></span></p>
                                    <p style="margin:10px 0px;padding:0px;list-style:none;"><span
                                            style="font-size:14px;"><span
                                                style="font-family:arial, helvetica, sans-serif;">&nbsp;►Tích điểm 3-8% giá
                                                trị đơn hàng cho mỗi lần mua và trừ tiền vào lần mua tiếp
                                                theo.</span></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="product-description">
                            <div class="title-bl">
                                <h4>Hướng dẫn bảo quản <span class="icon-open"></span></h4>
                            </div>
                            <div class="description-content" style="display: block;">
                                <div class="description-productdetail">
                                    <div class="description-productdetail">
                                        <p><span style="font-size:14px;"><span
                                                    style="font-family:arial, helvetica, sans-serif;"><span
                                                        style="color:rgb(88,89,91);background-color:rgb(248,248,248);">►</span>Có
                                                    thể giặt tay hay giặt máy đều được (ưu tiên giặt tay để tăng tuổi thọ
                                                    của sản phẩm)</span></span></p>
                                        <p><span style="font-size:14px;"><span
                                                    style="font-family:arial, helvetica, sans-serif;"><span
                                                        style="color:rgb(88,89,91);background-color:rgb(248,248,248);">►</span>Lộn
                                                    trái sản phẩm khi giặt, không giặt chung sản phẩm trắng với quần áo tối
                                                    màu.</span></span></p>
                                        <p><span style="font-size:14px;"><span
                                                    style="font-family:arial, helvetica, sans-serif;"><span
                                                        style="color:rgb(88,89,91);background-color:rgb(248,248,248);">►</span>Sử
                                                    dụng xà phòng trung tính,không sử dụng xà phòng có chất tẩy
                                                    mạnh.&nbsp;</span></span></p>
                                        <p><span style="font-size:14px;"><span
                                                    style="font-family:arial, helvetica, sans-serif;"><span
                                                        style="color:rgb(88,89,91);background-color:rgb(248,248,248);">►</span>Không
                                                    sử dụng chất tẩy, không ngâm sản phẩm.&nbsp;</span></span></p>
                                        <p><span style="font-size:14px;"><span
                                                    style="font-family:arial, helvetica, sans-serif;"><span
                                                        style="color:rgb(88,89,91);background-color:rgb(248,248,248);">►</span>Hạn
                                                    chế sấy ở nhiệt độ cao, bảo quản nơi khô ráo, thoáng mát, không phơi
                                                    trực tiếp dưới ánh nắng mặt trời.</span></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="show_comment">
                                    <h4 class="mb-4">1 bình luận cho sảm phẩm</h4>
                                    <div class="media mb-4">
                                        <img src="{{ asset('public/storage/images/logo_user.png') }}" alt="Image"
                                            class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                            <div class="text-primary mb-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam
                                                ipsum et no
                                                at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Bình luận sản phẩm</h4>

                                {{-- Rating here --}}
                                {{-- <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Đánh giá *:</p>
                                    <div class="text-primary">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div> --}}
                                {{-- <ul class="list-inline" title="average rating">
                                    <li title="star_rating" id="{{ $value->product_id }}-{{ $count }}"
                                        data-index="{{ $count }}" data-product="{{ $value->product_id }}"
                                        data-rating="{{ $rating }}" class="rating"
                                        style="cursor: pointer; {{ $color }} font-size:30px;">&#9733;</li>
                                </ul> --}}
                                <ul class="list-inline" title="average rating">
                                    @for ($count = 1; $count <= 5; $count++)
                                        @php
                                            if ($count <= $rating) {
                                                $color = 'color:#ffcc00;';
                                            } else {
                                                $color = 'color:#ccc;';
                                            }
                                        @endphp
                                        <li title="star_rating" id="{{ $pro_id }}-{{ $count }}"
                                            data-index="{{ $count }}" data-product="{{ $pro_id }}"
                                            data-rating="{{ $rating }}" class="rating"
                                            style="cursor: pointer;{{ $color }};font-size:30px;margin-right:10px;">
                                            &#9733;
                                        </li>
                                    @endfor
                                </ul>
                                <form>
                                    <div class="form-group">
                                        <label for="message">Nội dung <span style="color:red">*</span>:</label>
                                        <textarea id="comment" name="comment" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Họ tên <span style="color:red">*</span>:</label>
                                        <input type="text" class="form-control" name="comment_name"
                                            id="comment_name">
                                    </div>
                                    <div class="form-group mb-0">
                                        <button id="add_comment" type="button" value=""
                                            class="btn btn-primary px-3">Gửi
                                            bình luận</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                <div class="card product-item border-0">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                        <div class="d-flex justify-content-center">
                            <h6>$123.00</h6>
                            <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                            Detail</a>
                        <a href="" class="btn btn-sm text-dark p-0"><i
                                class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
                <div class="card product-item border-0">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="img/product-2.jpg" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                        <div class="d-flex justify-content-center">
                            <h6>$123.00</h6>
                            <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                            Detail</a>
                        <a href="" class="btn btn-sm text-dark p-0"><i
                                class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
                <div class="card product-item border-0">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="img/product-3.jpg" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                        <div class="d-flex justify-content-center">
                            <h6>$123.00</h6>
                            <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                            Detail</a>
                        <a href="" class="btn btn-sm text-dark p-0"><i
                                class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
                <div class="card product-item border-0">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="img/product-4.jpg" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                        <div class="d-flex justify-content-center">
                            <h6>$123.00</h6>
                            <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                            Detail</a>
                        <a href="" class="btn btn-sm text-dark p-0"><i
                                class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
                <div class="card product-item border-0">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="img/product-5.jpg" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                        <div class="d-flex justify-content-center">
                            <h6>$123.00</h6>
                            <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                            Detail</a>
                        <a href="" class="btn btn-sm text-dark p-0"><i
                                class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <script type="text/javascript">
        var is_busy = false;
        if (!$("input[name='color']:checked").val()) {
            $("input[name='size']").attr('disabled', true);
            $(".btn_size").attr('title', 'Bạn phải chọn màu trước');
        } else {
            $("input[name='size']").attr('disabled', false);
            $(".btn_size").removeAttr("title");
        }

        if (!$("input[name='size']:checked").val()) {
            $("#add_to_cart").attr('disabled', 'disabled');
            $("#buy_now").attr('disabled', 'disabled');
        } else {
            $("#add_to_cart").removeAttr('disabled');
            $("#buy_now").removeAttr('disabled');
        }

        $(document).on('input', '.qty_pro', function() {
            if (is_busy == true) return false;
            let id = $(this).data('id');
            let qty = $(this).val();
            is_busy = true;
            $.ajax({
                url: "{{ route('client.cart.checkQty') }}",
                type: "post",
                data: {
                    id: id,
                    qty: qty
                },
                dataType: "json",
                success: function(rsp) {
                    if ($.isEmptyObject(rsp.errors)) {
                        $('.check-qty').attr('disabled', false);
                    } else {
                        confirm_warning(rsp.errors);
                        $('.check-qty').attr('disabled', true);
                    }
                    // if (qty == rsp) {
                    //     // alert('Không thể thêm sản phẩm tiếp theo');
                    //     $('.check-qty').attr('disabled', true);
                    // } else {
                    //     $('.check-qty').attr('disabled', false);
                    // }
                    is_busy = false;
                },
                error: function() {
                    // $('.loading').hide();
                    alert("error!!!!");
                    is_busy = false;
                },
            });
        });

        function remove_background(product_id) {
            for (var count = 1; count <= 5; count++) {
                $('#' + product_id + '-' + count).css('color', '#ccc');
            }
        }

        // hover đánh giá
        $(document).on('mouseenter', '.rating', function() {
            var index = $(this).data('index');
            var product_id = $(this).data('product');
            remove_background(product_id);
            for (var count = 1; count <= index; count++) {
                $('#' + product_id + '-' + count).css('color', '#ffcc00');
            }
        });

        // nhả chuột ko đánh giá
        $(document).on('mouseleave', '.rating', function() {
            var index = $(this).data('index');
            var product_id = $(this).data('product');
            var rating = $(this).data('rating');
            remove_background(product_id);
            for (var count = 1; count <= rating; count++) {
                $('#' + product_id + '-' + count).css('color', '#ffcc00');
            }
        });

        // click đánh giá
        $(document).on('click', '.rating', function() {
            let index = $(this).data('index');
            let product_id = $(this).data('product');
            $.ajax({
                url: "{{ route('client.insertRating') }}",
                type: "POST",
                data: {
                    product_id: product_id,
                    index: index,
                },
                dataType: "json",
                success: function(rsp) {
                    confirm_success(rsp.success);
                },
                error: function() {
                    //$(".loading").hide();
                    alert("error!!!!");
                }
            });
        })

        $(document).on('click', '.comment_rate', function(e) {
            e.preventDefault();
            let id_product = $('#wishlist').attr('data-id');
            $.ajax({
                url: "{{ route('client.product.comment') }}",
                type: "POST",
                data: {
                    id_product: id_product
                },
                dataType: "json",
                success: function(rsp) {
                    $('#show_comment').html(rsp);
                },
                error: function() {
                    //$(".loading").hide();
                    alert("error!!!!");
                }
            });
        })

        $(document).on('click', '#add_comment', function() {
            let comment_name = $('#comment_name').val();
            let comment = $('#comment').val();
            let id_product = $('#wishlist').data('id');
            $.ajax({
                url: "{{ route('client.addComment') }}",
                type: "POST",
                data: {
                    comment_name: comment_name,
                    comment: comment,
                    id_product: id_product
                },
                dataType: "json",
                success: function(rsp) {
                    if ($.isEmptyObject(rsp.errors)) {
                        confirm_success(rsp.success);
                        load_comment(id_product);
                    } else {
                        confirm_warning(rsp.errors);
                    }
                },
                error: function() {
                    //$(".loading").hide();
                    alert("error!!!!");
                }
            });
        })

        $(document).on('click', '.btn_color', function() {
            if (is_busy) return false;
            var id_color = $(this).attr('data-color');
            var id_product = $(this).attr('data-id');
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
                    var show_size = show_variant(rsp.size);
                    $('.color-name').html(rsp.color_name);
                    $('#variant_size').html(show_size);
                    is_busy = false;
                },
                error: function() {
                    //$(".loading").hide();
                    alert("error!!!!");
                }
            });
        })

        $(document).on('click', '.btn_size', function() {
            if (is_busy) return false;
            if ($("input[name='color']:checked").val()) {
                var product_variant = $(this).data('pro');
                var product = $(this).attr('data-id');
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
                        var show_data = show(rsp.variant_id, rsp.pro_id);
                        var show_qty = show_input_qty(rsp.variant_id);
                        $('.btn_action').html(show_data);
                        $('.quantity').html(show_qty);
                        is_busy = false;
                    },
                    error: function() {
                        //$(".loading").hide();
                        alert("error!!!!");
                    }
                });
            } else {
                alert('Bạn chưa chọn màu');
            }
        });

        $(document).on('click', '#wishlist', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var price = $(this).data('price');
            var image = $(this).data('image');
            var url = $(this).data('url');
            var newItem = {
                'id': id,
                'url': url,
                'name': name,
                'price': price,
                'image': image
            }

            if (localStorage.getItem('data_wishlist') == null) {
                localStorage.setItem('data_wishlist', '[]');
            }

            var old_data = JSON.parse(localStorage.getItem('data_wishlist'));
            var matches = $.grep(old_data, function(obj) {
                return obj.id == id;
            });

            if (matches.length) {
                alert("Sản phẩm này bạn đã yêu thích.")
            } else {
                var add_wishlist = old_data.push(newItem);
                if (add_wishlist) {
                    alert("Thêm sản phẩm vào danh sách yêu thích thành công.");
                }
            }
            localStorage.setItem('data_wishlist', JSON.stringify(old_data));
            total = old_data.length;
            $('.wishlist_badge').html(total);
        });

        $(document).on('click', '#add_to_cart', function() {
            if (is_busy) return false;
            var product_id = $(this).data('product');
            var product_variant = $(this).data('variant');
            var qty = Number($('.product_quantity').val());
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
                    var name = rsp.product_detail_name;
                    var price = rsp.product_price - (rsp.product_price * rsp.product_discount / 100);
                    var thumbnail = rsp.product_details_thumb;
                    var cost_price = rsp.cost_price;
                    var newCart = {
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

                    var old_cart_data = JSON.parse(localStorage.getItem('data_cart'));
                    const itemExists = old_cart_data.find(item => {
                        if (item.id === product_variant) {
                            item.qty += qty;
                            return true;
                        }
                        return false;
                    })

                    if (!itemExists) {
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
        })

        $(document).on('click', '#buy_now', function() {
            if (is_busy) return false;
            var product_id = $(this).data('product');
            var product_variant = $(this).data('variant');
            var qty = Number($('.product_quantity').val());
            is_busy = true;
            $.ajax({
                url: "{{ route('client.cart.buy_now') }}",
                type: "POST",
                data: {
                    product_id: product_id,
                    product_variant: product_variant
                },
                dataType: "json",
                success: function(rsp) {
                    let name = rsp.product_detail_name;
                    let price = rsp.product_price - (rsp.product_price * rsp.product_discount / 100);
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
                    const itemExists = old_cart_data.find(item => {
                        if (item.id === product_variant) {
                            item.qty += qty;
                            return true;
                        }
                        return false;
                    })

                    if (!itemExists) {
                        old_cart_data.push(newCart);
                    }
                    localStorage.setItem('data_cart', JSON.stringify(old_cart_data));
                    num_in_cart();
                    window.location.href = "http://localhost/nadshop/cart/checkout";
                    is_busy = false;
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        });

        function show_input_qty(data) {
            var output = ''
            output += `<div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center qty_pro product_quantity" value="1" data-id='${data}' disabled>
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus check-qty">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>`;
            return output;
        }

        function show(data, data2) {
            var output = ''
            output +=
                `<button class="btn btn-dark px-3 mr-2" id="add_to_cart" data-variant="${data}" data-product="${data2}">Thêm vào giỏ hàng</button>
    <button class="btn btn-dark px-3 mr-2" id="buy_now" data-variant="${data}" data-product="${data2}">Mua ngay</button>`;
            return output;
        }

        function show_variant(data) {
            var output = '';
            if (data.length > 0) {
                $.each(data, function(key, value) {
                    output += `<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="size-check" name="size" id="btn_size${value.id}" autocomplete="off">
                    <label class="btn btn-outline-dark btn_size" data-pro="${value.proId}" data-id="${value.pId}" for="btn_size${value.id}">${value.size_name}</label>
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

        function load_comment(id) {
            $.ajax({
                url: "{{ route('client.loadComment') }}",
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(rsp) {
                    $('#show_comment').html(rsp);
                },
                error: function() {
                    //$(".loading").hide();
                    alert("error!!!!");
                }
            });
        }
    </script>
@endsection
