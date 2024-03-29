@extends('layouts.client')
@section('content')
    <style type="text/css">
        .s-filter {
            margin-right: 128px !important;
        }

        .list-inline {
            display: flex;
        }

        .paginationjs {
            display: flex;
        }

        .paginationjs-go-input {
            width: 37px;

        }

        .J-paginationjs-go-pagenumber {
            width: 35px;
            padding: 3px;
            margin-left: 7px;
        }

        .J-paginationjs-go-button {
            padding: 3px;
            margin-left: 12px;
        }
    </style>
    <div class="breadcrumb-shop clearfix bg-none px-xl-5">
        <div class="clearfix">
            <div class="">
                <ol class="breadcrumb breadcrumb-arrows clearfix">
                    <li><a href="{{ route('client.home') }}" target="_self"><i class="fa fa-home"></i>Trang chủ</a><i
                            class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                    <li>{{ $get_name_category->category_product_name }}</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="">
            <div class="d-flex px-xl-5">
                <div class="col-lg-8">
                    <h2>{{ $get_name_category->category_product_name }}</h2>
                    <div class="groupFilterNew d-flex" data-id="{{ $id }}">
                        <h5 class="mr-3">Bộ lọc</h5>
                        <div class="titleFilter clearfix d-flex">
                            <div class="layered_subtitle dropdown-filter">
                                <span>Màu sắc</span>
                                <span class="icon-control"><i class="fa fa-sort-down"></i></span>
                            </div>
                            <div class="layered_subtitle dropdown-filter">
                                <span>Kích cỡ</span>
                                <span class="icon-control"><i class="fa fa-sort-down"></i></span>
                            </div>
                            <div class="layered_subtitle dropdown-filter price-filter">
                                <span>Khoảng giá</span>
                                <span class="icon-control"><i class="fa fa-sort-down"></i></span>
                            </div>
                        </div>
                        <div class="contentFilter clearfix">
                            <div class="filter-color s-filter">
                                <ul class="check-box-list">
                                    @foreach ($list_color as $color)
                                        <li class="filter-item">
                                            <input type="checkbox" style="background-color:{{ $color->code_color }}"
                                                class='color-filter filter-check' value='{{ $color->id }}'>
                                        </li>
                                    @endforeach
                                    {{-- <li class="filter-item">
                                        <input type="checkbox" style="background-color: black"
                                            class='color-filter filter-check' value='2'>
                                    </li>
                                    <li class="filter-item">
                                        <input type="checkbox" style="background-color: yellow"
                                            class='color-filter filter-check' value='5'>
                                    </li>
                                    <li class="filter-item">
                                        <input type="checkbox" style="background-color: white"
                                            class='color-filter filter-check' value='7'>
                                    </li>
                                    <li class="filter-item">
                                        <input type="checkbox" style="background-color: pink"
                                            class='color-filter filter-check' value='6'>
                                    </li> --}}
                                </ul>
                            </div>
                            <div class="filter-size s-filter">
                                <ul class="check-box-list clearfix">
                                    @foreach ($list_size as $size)
                                        <li class="filter-item">
                                            <input type="checkbox" class="size-filter filter-check"
                                                value="{{ $size->id }}">
                                            <label>
                                                <span class="button tp_button"></span>
                                                {{ $size->size_name }}
                                            </label>
                                        </li>
                                    @endforeach
                                    {{-- <li class="filter-item">
                                        <input type="checkbox" class="size-filter filter-check" value="5">
                                        <label>
                                            <span class="button tp_button"></span>
                                            L </label>
                                    </li>
                                    <li class="filter-item">
                                        <input type="checkbox" class="size-filter filter-check" value='4'>
                                        <label>
                                            <span class="button tp_button"></span>
                                            M </label>
                                    </li>
                                    <li class="filter-item">
                                        <input type="checkbox" class="size-filter filter-check" value='3'>
                                        <label>
                                            <span class="button tp_button"></span>
                                            S </label>
                                    </li>
                                    <li class="filter-item">
                                        <input type="checkbox" class="size-filter filter-check" value='2'>
                                        <label>
                                            <span class="button tp_button"></span>
                                            XS </label>
                                    </li> --}}
                                </ul>
                            </div>
                            <div class="filter-price s-filter">
                                <ul class="check-box-list clearfix">
                                    <li class="filter-item">
                                        <input type="checkbox" class="price-filter filter-check" value="0">
                                        <label><span class="button tp_button"></span>Dưới 200.000đ</label>
                                    </li>
                                    <li class="filter-item">
                                        <input type="checkbox" class="price-filter filter-check" value="1">
                                        <label><span class="button tp_button"></span>Từ 200.000đ - 500.000đ </label>
                                    </li>
                                    <li class="filter-item">
                                        <input type="checkbox" class="price-filter filter-check" value="2">
                                        <label><span class="button tp_button"></span>Từ 500.000đ - 1000.0000đ </label>
                                    </li>
                                    <li class="filter-item">
                                        <input type="checkbox" class="price-filter filter-check" value="3">
                                        <label><span class="button tp_button"></span>Trên 1000.000đ</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="margin-top:40px">
                    <div class="custom-dropdown">
                        <label for="">Sắp xếp theo:</label>
                        <select name="sort_by" class="sort_by">
                            <option value="new" selected>Mới nhất</option>
                            <option value="priceDesc">Giá giảm dần</option>
                            <option value="priceAsc">Giá tăng dần</option>
                            {{-- <option value='discount'>Sale</option> --}}
                        </select>
                    </div>
                </div>
            </div>
            <div class="filter-here">
                <div class="row px-xl-5 pb-3">
                    @if ($list_products->isNotEmpty())
                        @foreach ($list_products as $product)
                            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                                <div class="card product-item border-0 mb-4">
                                    <div
                                        class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                        <img class="img-fluid w-100" src="{{ asset($product->product_thumb) }}"
                                            alt="">
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
                                            class="btn btn-sm text-dark p-0"><i
                                                class="fas fa-eye text-primary mr-1"></i>View
                                            Detail</a>
                                        <a href="" class="btn btn-sm text-dark p-0"><i
                                                class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-lg-12 col-md-6 col-sm-12 pb-1">
                            <p>Không có dữ liệu.</p>
                        </div>
                    @endif
                </div>
                {{-- <div id="pagination"></div> --}}
            </div>
            <div id="pagination"></div>
        </div>
    </div>
    <div class="show-modal-cart-buy">

    </div>
    </div>
    <!-- Shop End -->
    <script type="text/javascript">
        var is_busy = false;
        load_data();
        $(document).on('click', '.filter-check', function() {
            var price_filter = get_filter('price-filter');
            load_data();
        })

        $(document).on('click', '.btn_color', color_check);

        $('body').on('click', '#size_check', size_check);

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

        $(document).on('change', '.sort_by', function() {
            load_data();
        })

        $(document).on('click', '.btn_buy_now', buy_now);

        function get_filter(class_name) {
            var filter = [];
            $("ul li input." + class_name + ":checked").each(function() {
                filter.push($(this).val());
            });
            return filter;
        }

        function load_data() {
            $('.loading').show();
            var color_filter = get_filter('color-filter');
            var size_filter = get_filter('size-filter');
            var price_filter = get_filter('price-filter');
            var cat_id = $('.groupFilterNew').attr('data-id');
            var sort_by = $('.sort_by').val();
            $.ajax({
                url: "{{ route('client.product.filter') }}",
                type: "POST",
                data: {
                    color_filter: color_filter,
                    size_filter: size_filter,
                    price_filter: price_filter,
                    sort_by: sort_by,
                    cat_id: cat_id
                },
                dataType: "json",
                success: function(rsp) {
                    $('.loading').hide();
                    var total = rsp.list_product.length;
                    var data = rsp.list_product;
                    pagination(data, total);
                },
                error: function() {
                    $(".loading").hide();
                    alert("error!!!!");
                }
            });
        }

        function render_button(data, data2) {
            var output = ''
            output +=
                `<button class="btn btn-dark px-3 mr-2" id="buy_now" data-variant="${data}" data-product="${data2}">Sỡ hữu ngay</button>`
            return output;
        }

        // function render_qty(data) {
        //     var output = ''
        //     output +=
        //         `<div class="input-group quantity mr-3" style="width: 130px;">
    //                 <div class="input-group-btn">
    //                     <button class="btn btn-primary btn-minus">
    //                         <i class="fa fa-minus"></i>
    //                     </button>
    //                 </div>
    //                 <input type="text" class="form-control bg-secondary text-center product_quantity" value="1" data-id='${data}' disabled>
    //                 <div class="input-group-btn">
    //                     <button class="btn btn-primary btn-plus check-qty">
    //                         <i class="fa fa-plus"></i>
    //                     </button>
    //                 </div>
    //             </div>`
        //     return output;
        // }

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
                        if (rsp.qty_variant > 0) {
                            let show = render_button(rsp.variant_id, rsp.pro_id);
                            $('.btn_buy').html(show);
                            $('#status_product_cat').text('Còn hàng');
                        } else {
                            $('.btn_buy').removeClass('d-flex');
                            $('.btn_buy').addClass('d-none');
                            $('#status_product_cat').text('Hết hàng');
                        }
                        is_busy = false;
                    },
                    error: function() {
                        alert("error!!!!");
                        is_busy = false;
                    }
                });
            } else {
                alert('Bạn chưa chọn màu');
                is_busy = false;
            }
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


        function pagination(data, total) {
            if (data.length > 0) {
                $('#pagination').pagination({
                    dataSource: data,
                    locator: 'data',
                    showGoInput: true,
                    showGoButton: true,
                    totalNumber: total,
                    pageSize: 20,
                    callback: function(data, pagination) {
                        var show = show_data(data);
                        $('.filter-here').html(show);
                        if (pagination.pageNumber = 1) {
                            $('#pagination').hide();
                        } else {
                            $('#pagination').show();
                        }
                    }
                })
            } else {
                $('.filter-here').html('<p class="px-xl-5">Không có dữ liệu.</p>');
            }
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
                                <strong class="pt-1" id="status_product_cat"></strong>
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

        function show_data(data) {
            var output = "";
            output += `<div class="row px-xl-5 pb-3">`;
            if (data.length > 0) {
                $.each(data, function(key, value) {
                    var price = currencyFormat(value.product_price - (value.product_price * value.product_discount /
                        100));
                    var format_price = currencyFormat(value.product_price);
                    output += `<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
    <div class="card product-item border-0 mb-4">
        <div
            class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <img class="img-fluid w-100" src='http://localhost/nadshop/${value.product_thumb}' alt="">
        </div>
        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <h6 class="text-truncate mb-3">${value.product_name}</h6>
            <div class="d-flex justify-content-center">
                <h6>${price}</h6>
                <h6 class="text-muted ml-2"><del>${format_price}</del></h6>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="http://localhost/nadshop/product/${value.id}" class="btn btn-sm text-dark p-0 btn_view"><i
                            class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                    <a class="btn btn-sm text-dark p-0 btn_buy_now" data-id="${value.id}"><i
                            class="fas fa-shopping-cart text-primary mr-1"></i>Mua ngay</a>
        </div>
    </div>
</div>`;
                });
            } else {
                output += `<p>Không có dữ liệu.</p>`
            }
            output += `</div>`;
            return output;
        }

        function currencyFormat(val, unit = 'đ') {
            if (val != null) {
                return val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + unit;
            } else {
                return "";
            }
        }
    </script>
@endsection
