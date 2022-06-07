@extends('layouts.client')
@section('content')
<div class="breadcrumb-shop clearfix bg-none px-xl-5">
    <div class="clearfix">
        <div class="">
            <ol class="breadcrumb breadcrumb-arrows clearfix">
                <li><a href="{{ route('client.home') }}" target="_self"><i class="fa fa-home"></i>Trang chủ</a><i
                        class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                <li>Áo Phông</li>
            </ol>
        </div>
    </div>
</div>
<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
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
                            <li class="filter-item">
                                <input type="checkbox" style="background-color: black" class='color-filter filter-check'
                                    value='2'>
                            </li>
                            <li class="filter-item">
                                <input type="checkbox" style="background-color: yellow"
                                    class='color-filter filter-check' value='5'>
                            </li>
                            <li class="filter-item">
                                <input type="checkbox" style="background-color: white" class='color-filter filter-check'
                                    value='7'>
                            </li>
                            <li class="filter-item">
                                <input type="checkbox" style="background-color: pink" class='color-filter filter-check'
                                    value='6'>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-size s-filter">
                        <ul class="check-box-list clearfix">
                            <li class="filter-item">
                                <input type="checkbox" class="size-filter filter-check" value="xl">
                                <label>
                                    <span class="button tp_button"></span>
                                    XL
                                </label>
                            </li>
                            <li class="filter-item">
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
                            </li>
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
        <div class="col-lg-4">
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
        <div class="filter-here">
            <div class="row px-xl-5 pb-3">
                @if($list_products->isNotEmpty())
                @foreach ($list_products as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div
                            class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="{{ asset($product->product_thumb) }}" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $product->product_name }}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>{{ currentcyFormat($product->product_price) }}</h6>
                                <h6 class="text-muted ml-2"><del>{{ currentcyFormat($product->product_price) }}</del>
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{ route('client.product.detail',$product->id) }}"
                                class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
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
</div>
<!-- Shop End -->
<script type="text/javascript">
    load_data();
    $(document).on('click','.filter-check',function(){
        var price_filter = get_filter('price-filter');
    load_data();
})

$(document).on('change','.sort_by',function(){
  load_data();
})


function get_filter(class_name){
    var filter = [];
    $("ul li input." + class_name + ":checked").each(function () {
      filter.push($(this).val());
    });
    return filter;
}

function load_data(){
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
            color_filter:color_filter,
            size_filter:size_filter,
            price_filter:price_filter,
            sort_by:sort_by,
            cat_id:cat_id
        },
        dataType: "json",
        success: function (rsp) {
            $('.loading').hide();
            var total = rsp.list_product.length;
            var data = rsp.list_product;
            pagination(data,total);
        },error: function () {
            $(".loading").hide();
            alert("error!!!!");
        }
    });
}


function pagination(data,total){
    $('#pagination').pagination({
        dataSource: data,
        locator: 'data',
        totalNumber: total,
        pageSize: 2,
        callback: function(data, pagination){
           var show = show_data(data);
           $('.filter-here').html(show);
        }
    })
}

function show_data(data){
    var output = "";
    output += `<div class="row px-xl-5 pb-3">`;
   if(data.length > 0){
    $.each(data, function (key, value) {
        var price = currencyFormat(value.product_price);
 output += `<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
    <div class="card product-item border-0 mb-4">
        <div
            class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <img class="img-fluid w-100" src='http://localhost:8080/nadshop/${value.product_thumb}' alt="">
        </div>
        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <h6 class="text-truncate mb-3">${value.product_name}</h6>
            <div class="d-flex justify-content-center">
                <h6>${price}</h6>
                <h6 class="text-muted ml-2"><del>${price}</del></h6>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between bg-light border">
            <a href="http://localhost:8080/nadshop/product/cat/${value.id}"
                class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                Detail</a>
            <a href="" class="btn btn-sm text-dark p-0"><i
                    class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
        </div>
    </div>
</div>`;
    });
}else{
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
