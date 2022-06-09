@extends('layouts.client')
@section('content')
<div class="breadcrumb-shop clearfix px-xl-5 bg-none">
    <div class="padding-lf-40 clearfix">
        <div class="">
            <ol class="breadcrumb breadcrumb-arrows clearfix">
                <li><a href="{{ route('client.home') }}" target="_self"><i class="fa fa-home"></i>Trang chủ</a><i
                        class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                <li><a href="{{ route('client.product.cat.show',$product->product_cat_id) }}" target="_self">{{
                        $product->category->category_product_name }}</a><i
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
            <div class="mb-3">
                <strong class="pt-1">Còn hàng</strong>
            </div>
            <h3 class="font-weight-semi-bold mb-4">{{ currentcyFormat($product->product_price) }}</h3>
            <div class="mb-4">
                <div class="info-color d-flex">
                    <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Màu sắc:</p>
                    <span class="color-name"></span>
                </div>
                <div class="my-2">
                    @if($list_colors->isNotEmpty())
                    @foreach ($list_colors as $color)
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="color_check" name="color" id="btn_color{{$color->id}}"
                            autocomplete="off">
                        <label class="color-label btn_color" data-color="{{ $color->id }}" data-id="{{ $color->proId }}"
                            data-toggle="tooltip" title="{{ $color->color_name }}"
                            style="background-color:{{ $color->code_color }}" for="btn_color{{ $color->id }}">
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
                    <input type="text" class="form-control bg-secondary text-center quantity" value="1">
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
                    <button class="btn btn-dark px-5" id="wishlist"><i class="far fa-heart mr-2"></i>Yêu
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
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh giá</a>
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
                                            style="font-family:arial, helvetica, sans-serif;">&nbsp;►Đổi hàng&nbsp;trong
                                            vòng 5&nbsp;ngày.</span></span></p>
                                <p style="margin:10px 0px;padding:0px;list-style:none;"><span
                                        style="font-size:14px;"><span
                                            style="font-family:arial, helvetica, sans-serif;">&nbsp;►Giảm đến 15% trên
                                            tổng hóa đơn khi mua hàng ( tại cửa hàng ) vào tháng sinh
                                            nhật.</span></span></p>
                                <p style="margin:10px 0px;padding:0px;list-style:none;"><span
                                        style="font-size:14px;"><span
                                            style="font-family:arial, helvetica, sans-serif;">&nbsp;►Giao hàng nội thành
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
                            <h4 class="mb-4">1 review for "Colorful Stylish Shirt"</h4>
                            <div class="media mb-4">
                                <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
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
                        <div class="col-md-6">
                            <h4 class="mb-4">Leave a review</h4>
                            <small>Your email address will not be published. Required fields are marked
                                *</small>
                            <div class="d-flex my-3">
                                <p class="mb-0 mr-2">Your Rating * :</p>
                                <div class="text-primary">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="message">Your Review *</label>
                                    <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name">Your Name *</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Your Email *</label>
                                    <input type="email" class="form-control" id="email">
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-5">
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
</div>
<script type="text/javascript">
    var is_busy = false;
    var quantity = $('.quantity');
    $('.btn-plus').click(function () {
        quantity.val(Number(quantity.val()) + 1).trigger('input');
    });

    $('.btn-minus').click(function () {
        quantity.val(Math.max(Number(quantity.val()) - 1, 1)).trigger('input');
    });

    if(!$("input[name='color']:checked").val()){
        $("input[name='size']").attr('disabled',true);
        $(".btn_size").attr('title','Bạn phải chọn màu trước');
    }else{
        $("input[name='size']").attr('disabled',false);
        $(".btn_size").removeAttr("title");
    }

    if(!$("input[name='size']:checked").val()){
        $("#add_to_cart").attr('disabled','disabled');
        $("#buy_now").attr('disabled','disabled');
    }else{
        $("#add_to_cart").removeAttr('disabled');
        $("#buy_now").removeAttr('disabled');
    }

    $(document).on('click','.btn_color',function(){
      if(is_busy) return false;
      var id_color = $(this).attr('data-color');
      var id_product = $(this).attr('data-id');
      is_busy = true;
      $.ajax({
        url: "{{ route('client.product.variant') }}",
        type: "POST",
        data: {
            id_color:id_color,
            id_product:id_product
     },
        dataType: "json",
        success: function (rsp) {
            //$('.loading').hide();
            var show_size = show_variant(rsp.size);
            $('.color-name').html(rsp.color_name);
            $('#variant_size').html(show_size);
            is_busy = false;
        },error: function () {
            //$(".loading").hide();
            alert("error!!!!");
        }
     });
    })

    $(document).on('click','.btn_size',function(){
        if(is_busy) return false;
        if($("input[name='color']:checked").val()){
            var product_variant = $(this).data('pro');
            var product = $(this).attr('data-id');
            is_busy = true;
            $.ajax({
              url: "{{ route('client.product.change') }}",
              type: "POST",
              data: {
                product_variant:product_variant,
                product:product
           },
              dataType: "json",
              success: function (rsp) {
                  var show_data = show(rsp.variant_id,rsp.pro_id);
                  $('.btn_action').html(show_data);
                  is_busy = false;
              },error: function () {
                  //$(".loading").hide();
                  alert("error!!!!");
              }
          });
        }else{
            alert('Bạn chưa chọn màu');
        }
    });

function show(data,data2){
    var output = ''
    output += `<button class="btn btn-dark px-3 mr-2" id="add_to_cart" data-variant="${data}" data-product="${data2}">Thêm vào giỏ hàng</button>
    <button class="btn btn-dark px-3 mr-2" id="buy_now" data-variant="${data}" data-product="${data2}">Mua ngay</button>`;
    return output;
}

 function show_variant(data){
        var output = '';
        if(data.length > 0){
            $.each(data, function (key, value){
                output += `<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="size-check" name="size" id="btn_size${value.id}" autocomplete="off">
                    <label class="btn btn-outline-dark btn_size" data-pro="${value.proId}" data-id="${value.pId}" for="btn_size${value.id}">${value.size_name}</label>
                </div>`;
            });
            //output += `<p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Số lượng còn lại: ${value.product_qty_stock}</p>`;
        }else{
            output += `<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <p class="text-dark font-weight-medium mb-0 mr-3 mb-2">Phiên bản này không còn</p>
            </div>`;
        }
        return output;
    }
</script>
@endsection
