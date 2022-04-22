@extends ('layouts.admin') @section('title', 'Danh sách bài viết')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">Danh sách sản phẩm</div>
        <div class="card-body">
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
                    @if ($list_product_details->total() > 0) @php $temp = 0;
                    @endphp @foreach ($list_product_details as $item) @php
                    $temp++; @endphp
                    <tr>
                        <th scope="row">{{ $temp }}</th>
                        <td>
                            <img src="{{ asset($item->product_details_thumb) }}" width="80px" height="80px" alt="" />
                        </td>
                        <td>{{ $item->product_detail_name }}</td>
                        <td>{{ currentcyFormat($item->product_price) }}</td>
                        <td>{{ formatDateToDMY($item->created_at) }}</td>
                        @if($item->product_qty_stock > 0)
                        <td>
                            <span class="badge badge-success">Còn hàng</span>
                        </td>
                        @else
                        <td>
                            <span class="badge badge-dark">Hết hàng</span>
                        </td>
                        @endif
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white edit-prodetail" type="button"
                                data-id="{{ $item->id }}" data-url="{{
                                    route('admin.product.detail.edit')
                                }}" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white delete-prodetail"
                                type="button" data-id="{{ $item->id }}" data-url="{{
                                    route('admin.product.detail.delete')
                                }}" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach @else
                    <tr>
                        <td colspan="7" class="bg-white">
                            <p>Không có bản ghi nào.</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {{ $list_product_details->links('layouts.paginationlink') }}
        </div>
    </div>
</div>
<div id="modalPopupEdit"></div>
<script type="text/javascript">
    $(document).on("click", ".edit-prodetail", function () {
        $(".loadajax").show();
        var url_edit = $(this).attr("data-url");
        var proId = $(this).attr("data-id");
        var data = { proId: proId };
        $.ajax({
            url: url_edit,
            type: "GET",
            dataType: "json",
            data: data,
            success: function (rsp) {
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
            },
            error: function () {
                $(".loadajax").hide();
                alert("error!!!!");
            },
        });
    });

    $(document).on("click", "#btn_edit", function () {
        $(".loadajax").show();
        var id = $(".proDetailId").attr("data-id");
        var url_update = $(".proDetailId").attr("data-url");
        var product_detail_name = $("#product_name").val();
        var product_price = $("#product_price").val();
        var product_discount = $("#product_discount").val();
        var product_qty_stock = $("#stock").val();
        var product_color = $("#color").val();
        var product_size = $("#size_ver").val();
        var product_details_thumb = $("#thumbnail").val();
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
            success: function (data) {
                $(".loadajax").hide();
                if ($.isEmptyObject(data.errors)) {
                    confirm_success(data.success);

                } else {
                    confirm_warning(data.errors);
                }
            },
            error: function () {
                $(".loadajax").hide();
                alert("error!!!!");
            },
        });
        window.location.reload();
    });

    $(document).on("click", ".delete-prodetail", function () {
        var url_delete = $(this).attr("data-url");
        var id = $(this).attr("data-id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                $.ajax({
                    url: url_delete,
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function (data) {
                        $(".loadajax").hide();
                        if ($.isEmptyObject(data.errors)) {
                            confirm_success(data.success);
                        } else {
                            confirm_warning(data.errors);
                        }
                    },
                    error: function () {
                        $(".loadajax").hide();
                        alert("error!!!!");
                    },
                });
                $(".loadajax").show();
                window.location.reload();
            }
        });
    });

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
        $.each(color, function (key, value) {
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
        $.each(size, function (key, value) {
            let selected =
                value.id == product_detail.size_id ? "selected" : null;
            output += `<option value="${value.id}" ${selected}>${value.size_name}</option>`;
        });
        output += `</select></div></div></div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group row ">
                                        <label for="" class="col-sm-4 control-label">Ảnh:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="thumbnail" name="product_thumbnail">
                                                <option value="">Chọn ảnh chi tiết</option>`;
        $.each(image, function (key, value) {
            let selected =
                value.image == product_detail.product_details_thumb
                    ? "selected"
                    : null;
            output += `<option value="${value.image}" ${selected}>${value.img_name}</option>`;
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
</script>

@endsection
