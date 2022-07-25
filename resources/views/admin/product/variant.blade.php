@extends ('layouts.admin')
@section('title', 'Danh sách bài viết')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5>Danh sách sản phẩm chi tiết</h5>
            <div class="form-search form-inline">
                <form class="form-search" action="" method="GET">
                    <input type="text" class="form-control keyword" name="kw" placeholder="Nhập từ khóa..." />
                    <button type="button" name="btn-search" class="btn btn-primary" id="btn_search">Tìm kiếm</button>
                    <input type="hidden" data-url="{{ route('admin.product.detail.list') }}" class="url">
                </form>
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="analytic">
                <a href="{{ request()->url() }}" class="text-primary">Kích hoạt<span class="text-muted">|</span></a>
                <a href="{{ request()->url() }}?status=pending" class="text-primary">Chờ duyệt<span class="text-muted">
                        |</span></a>
                <a href="{{ request()->url() }}?status=trash" class="text-primary">Vô hiệu hóa<span
                        class="text-muted"></span></a>
            </div>
            <form action="{{ route('admin.product.action') }}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option>Chọn</option>
                        @foreach ($list_act as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary" />
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($list_variant->total() > 0)
                        @php
                        $temp = 0;
                        @endphp
                        @foreach ($list_variant as $item)
                        @php
                        $temp++;
                        @endphp
                        <tr>
                            <th scope="row">{{ $temp }}</th>
                            <td>
                                <img src="{{ asset($item->product_details_thumb) }}" width="80px" height="80px"
                                    alt="" />
                            </td>
                            <td>{{ $item->product_detail_name }}</td>
                            <td>{{ currentcyFormat($item->product_price) }}</td>
                            <td>{{ formatDateToDMY($item->created_at) }}</td>
                            @if ($item->product_qty_stock > 0)
                            <td>
                                <span class="badge badge-success">Còn hàng</span>
                            </td>
                            @else
                            <td>
                                <span class="badge badge-dark">Hết hàng</span>
                            </td>
                            @endif
                            <td>
                                <a class="btn btn-success btn-sm rounded-0 text-white edit-prodetail" type="button"
                                    data-id="{{ $item->id }}" data-url="{{ route('admin.product.detail.edit') }}"
                                    data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-danger btn-sm rounded-0 text-white delete-prodetail" type="button"
                                    data-id="{{ $item->id }}" data-url="{{ route('admin.product.detail.delete') }}"
                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                <a class="btn btn-primary btn-sm rounded-0 text-white show-prodetail" type="button"
                                    data-id="{{ $item->id }}" data-url="" data-placement="top" title="Detail"><i
                                        class="fa fa-asterisk" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="bg-white">
                                <p>Không có bản ghi nào.</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </form>
            {{ $list_variant->links('layouts.paginationlink') }} --}}
        </div>
    </div>
</div>
<div id="modalPopupEdit"></div>
<div id="modalPopupDetail">
</div>
<script type="text/javascript">
    load_variant(1, "");

        $(document).on('click', '.show-prodetail', function() {
            var id = $(this).attr('data-id');
            $(".loadajax").show();
            $.ajax({
                url: "{{ route('admin.product.detail.show') }}",
                type: "GET",
                dataType: "html",
                data: {
                    id: id
                },
                success: function(rsp) {
                    $(".loadajax").hide();
                    $("#modalPopupDetail").html(rsp);
                    $(".modal-detail").modal("show");
                },
                error: function() {
                    $(".loadajax").hide();
                    alert("error!!!!");
                },
            });
        });

        $(document).on('click','#add_variant',function(){
            let id = getParameter('id');
            $(".loadajax").show();
            $.ajax({
                url: "{{ route('admin.product.detail.addVariant') }}",
                type: "GET",
                dataType: "html",
                data: {
                    id: id
                },
                success: function(rsp) {
                    $(".loadajax").hide();
                    $('#modalPopupDetail').html(rsp);
                    $('.variant_modal').modal('show');
                    $('#select_thumbnail').ddslick();
                },
                error: function() {
                    $(".loadajax").hide();
                    alert("error!!!!");
                },
            });
        })

        $(document).on('click','#btn_save_variant',function(){
              $('.loadajax').show();
              let id = $(this).data('id');
              let thumbnail = $('.dd-selected-value').val();
              let fm_data = $('#fm_variant_product').serializeArray();
              fm_data.push({ name: "id", value: id });
              fm_data.push({ name: "thumbnail", value: thumbnail });
              $.ajax({
                url: "{{ route('admin.product.detail.storeVariant') }}",
                type: "post",
                data: fm_data,
                dataType: "json",
                success: function (rsp) {
                    $('.loadajax').hide();
                    if ($.isEmptyObject(rsp.errors)) {
                        confirm_success(rsp.success);
                        $('.variant_modal').modal('hide');
                        load_variant(1,'');
                    } else {
                        confirm_warning(rsp.errors);
                    }
                },error: function () {
                    alert("error!!!!");
                },
            });
        });

        $(document).on("click", ".edit-prodetail", function() {
            $(".loadajax").show();
            var url_edit = $(this).attr("data-url");
            var proId = $(this).attr("data-id");
            var data = {
                proId: proId
            };
            $.ajax({
                url: url_edit,
                type: "GET",
                dataType: "json",
                data: data,
                success: function(rsp) {
                    var color = rsp.list_product_color;
                    var size = rsp.list_product_size;
                    var image = rsp.list_image;
                    var product_detail = rsp.product_detail;
                    var url_update = rsp.url_update;
                    var show = showToHtml(
                        url_update,
                        color,
                        size,
                        image,
                        product_detail
                    );
                    $(".loadajax").hide();
                    $("#modalPopupEdit").html(show);
                    $(".edit-modal").modal("show");
                    $('#thumbnail').ddslick();
                },
                error: function() {
                    $(".loadajax").hide();
                    alert("error!!!!");
                },
            });
        });

        $(document).on("click", "#btn_edit", function() {
            //$(".loadajax").show();
            var page = $(location).attr('href').split('page=')[1];
            var id = $(".proDetailId").attr("data-id");
            var url_update = $(".proDetailId").attr("data-url");
            var product_detail_name = $("#product_name").val();
            var product_price = $("#product_price").val();
            var product_discount = $("#product_discount").val();
            var product_qty_stock = $("#stock").val();
            var product_color = $("#color").val();
            var product_size = $("#size_ver").val();
            var product_details_thumb = $(".dd-selected-value").val();
            var data = {
                id: id,
                product_detail_name: product_detail_name,
                product_price: product_price,
                product_discount: product_discount,
                product_qty_stock: product_qty_stock,
                product_color: product_color,
                product_size: product_size,
                product_details_thumb: product_details_thumb,
            };
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: url_update,
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                    $(".loadajax").hide();
                    if ($.isEmptyObject(data.errors)) {
                        confirm_success(data.success);
                        $('#myModal').modal('hide');
                        load_variant(1,'');
                    } else {
                        confirm_warning(data.errors);
                    }
                },
                error: function() {
                    $(".loadajax").hide();
                    alert("error!!!!");
                },
            });
        });

        $(document).on("click", ".delete-prodetail", function() {
            var url_delete = $(this).attr("data-url");
            var page = $(location).attr('href').split('page=')[1];
            var id = $(this).attr("data-id");
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: url_delete,
                type: "POST",
                dataType: "json",
                data: {
                    id: id
                },
                beforeSend: function() {
                    return confirm("Bạn thực sự muốn xóa?");
                },
                success: function(rsp) {
                    $(".loadajax").hide();
                    confirm_success(rsp.success);
                    loadData(page);
                },
                error: function() {
                    $(".loadajax").hide();
                    alert("error!!!!");
                },
            });
        });

        $(document).on('click', '#btn_search', function(e) {
            var url = $('.url').attr('data-url');
            var query = $('.keyword').val();
            var page = 1;
            // history.pushState(null, '', url + "?kw=" + query);
            load_variant(page, query);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            // var url = "http://localhost/nadshop/admin/product/variant?id=21";
            var page = $(this).attr('href').split('page=')[1];
            var query = $('.keyword').val();
            // if (query != "") {
            //     history.pushState(null, '', url + "?page=" + page + "&kw=" + query);
            // } else {
            //     history.pushState(null, '', url + "?page=" + page);
            // }
            load_variant(page, query);
        });

        function load_variant(page, query) {
            let id = getParameter('id');
            $(".loadajax").show();
            $.ajax({
                url: "{{ route('admin.product.variant') }}" + "?page=" + page + "&kw=" + query,
                type: "GET",
                data: {
                    id: id
                },
                dataType: "html",
                success: function(rsp) {
                    $(".loadajax").hide();
                    $('.card .card-body').html(rsp);
                },
                error: function() {
                    alert("error!!!!");
                },
            });
        }

        function showToHtml(url, color, size, image, product_detail) {
            var output = ``;
            output += `<div class="modal fade draggable edit-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-lg ui-draggable">`;
            output += `<div class="modal-content p-3">
                <form method='POST' id="fm_update">
                    @csrf
                    <div class="modal-header ui-dranggale-handle" style="cursor: move;">
                        <h5 class="modal-title">Sửa chi tiết sản phẩm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <ul class="nav nav-tabs mt-3 mb-3" id="myTab">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="p_1-tab" data-toggle="tab" href="#p_1" role="tab"
                                aria-selected="true">Tab</a>
                        </li>
                    </ul>`;
            output += `<div class="tab-content" id="myTabContent">
                        <input type="hidden" name="reqID" value="" id="req-id">
                        <div class="tab-pane fade show active" id="p_1" role="tabpanel" aria-labelledby="p_1-tab">`;
            output += `<div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group row">
                                        <label for="product_name" class="col-sm-4 control-label">Tên sản
                                            phẩm:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="product_name"
                                                placeholder="Tên sản phẩm" name="product_detail_name" value="${product_detail.product_detail_name}">
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <label for="product_price" class="col-sm-4 control-label">Giá:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="product_price"
                                                placeholder="Giá sản phẩm (VNĐ)" name="product_price" value="${product_detail.product_price}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="product_discount" class="col-sm-4 control-label">Khuyến
                                            mãi:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="product_discount"
                                                placeholder="Khuyến mãi (%)" name="product_discount" value="${product_detail.product_discount}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="stock" class="col-sm-4 control-label">Số
                                            lượng:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="stock"
                                                placeholder="Số lượng sản phẩm" name="product_qty_stock" value="${product_detail.product_qty_stock}">
                                        </div>
                                    </div>`;
            output += `<div class="form-group row">
                                        <label for="color" class="col-sm-4 control-label">Màu:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="color" name="product_color">
                                                <option value="">Chọn màu</option>`;
            $.each(color, function(key, value) {
                let selected =
                    value.id == product_detail.color_id ? "selected" : null;
                output += `<option value="${value.id}" ${selected}>${value.color_name}</option>`;
            });
            output += `</select></div></div>`;
            output += `<div class="form-group row">
                                        <label for="size_ver" class="col-sm-4 control-label">Kích
                                            cỡ/bản:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="size_ver" name="product_size">`;
            output += `<option value="">Chọn kích cỡ/phiên bản</option>`;
            $.each(size, function(key, value) {
                let selected =
                    value.id == product_detail.size_id ? "selected" : null;
                output += `<option value="${value.id}" ${selected}>${value.size_name}</option>`;
            });
            output += `</select></div></div></div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">Ảnh:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="thumbnail" name="product_thumbnail">
                                                <option value="">Chọn ảnh chi tiết</option>`;
            $.each(image, function(key, value) {
                let selected =
                    value.image == product_detail.product_details_thumb ?
                    "selected" :
                    null;
                    output += `<option data-imagesrc="http://localhost/nadshop/storage/app/public/images/product/thumb/${value.image}" value="${value.image}" ${selected}></option>`;
            });
            output += `</select></div></div></div></div></div></div>`;
            output += `<div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" name="btn_edit" class="btn btn-primary" id="btn_edit">Lưu</buton>
                    </div>
                    <input class="proDetailId" type="hidden" data-id ="${product_detail.id}" data-url="${url}">
                </form>
            </div>
        </div>
    </div>
    `;
            return output;
        }

        function getParameter(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
</script>
@endsection
