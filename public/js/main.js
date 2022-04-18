
$(document).ready(function () {

    $(".nav-link.active .sub-menu").slideDown();

    $(document).on('click', '#sidebar-menu .arrow', function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });

    $(document).on('click', '#checkall', function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(".alert")
        .fadeTo(2000, 500)
        .slideUp(500, function () {
            $("#success-alert").slideUp(500);
        });

    $(document).on('click', '#avatar', function () {
        $("#img").click();
    });

    var url = $('#add_product_detail').attr('data-url');
    $(document).on("click", "#add_product_detail", function () {
        var proId = $(this).attr('data-id');
        var output = ``;
        $('.loadajax').css('display', 'block');
        $.ajax({
            type: "GET",
            url: url,
            data: {
                proId: proId
            },
            dataType: "json",
            success: function (resp) {
                output += `<div class="modal fade draggable detail-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg ui-draggable" role="document">
                                    <div class="modal-content p-3">
                                        <form id="fm_detail_product" action>
                                            <div class="modal-header ui-dranggale-handle" style="cursor: move;">
                                                <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết sản phẩm</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <ul class="nav nav-tabs mt-3 mb-3" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="p_1-tab" data-toggle="tab" href="#p_1" role="tab"
                                                        aria-selected="true">Product</a>
                                                    <span class="remove-product-tab"><i class="fa fa-times" aria-hidden="true"></i>
                                                    </span>
                                                <li class="nav-item"><a class="nav-link" href="#" id="add_work"><i
                                                            class="fa fa-plus" aria-hidden="true"></i></a></li>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="p_1" role="tabpanel" aria-labelledby="p_1-tab">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-xs-12">
                                                            <div class="form-group row">
                                                                <label for="product_name" class="col-sm-4 control-label">Tên sản
                                                                    phẩm:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control product_name"
                                                                        placeholder="Tên sản phẩm" name="product_detail_name[]">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row ">
                                                                <label for="product_price" class="col-sm-4 control-label">Giá:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control product_price"
                                                                        placeholder="Giá sản phẩm (VNĐ)" name="product_price[]">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="product_discount" class="col-sm-4 control-label">Khuyến
                                                                    mãi:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control product_discount"
                                                                        placeholder="Khuyến mãi (%)" name="product_discount[]">
                                                                </div>
                                                            </div>`;
                output += `<div class="form-group row">
                                <label for="stock" class="col-sm-4 control-label">Số
                                    lượng:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control stock"
                                        placeholder="Số lượng sản phẩm" name="product_qty_stock[]">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="color" class="col-sm-4 control-label">Màu:</label>
                                <div class="col-sm-8">
                                    <select class="form-control color" name="product_color[]">
                                        <option selected>Chọn màu</option>`;
                $.each(resp.list_product_color, function (key, value) {
                    output += `<option value="${value.id}">${value.color_name}</option>`;
                });
                output += `</select></div></div><div class="form-group row"><label for="size_ver" class="col-sm-4 control-label">Kích
                cỡ/bản:</label>
                <div class="col-sm-8">
                <select class="form-control size_ver" name="product_size[]">
                <option selected>Chọn kích cỡ/phiên bản</option>`;
                $.each(resp.list_product_size, function (key, value) {
                    output += `<option value="${value.id}">${value.size_name}</option>`;
                });
                output += `</select></div></div></div>
                <div class="col-sm-6 col-xs-12">
                <div class="form-group row ">
                <label for="" class="col-sm-4 control-label">Ảnh chi tiết:</label>
                <div class="col-sm-8">
                    <select id="selectBox" class="form-control thumbnail" name="product_details_thumb[]">
                        <option selected>Chọn ảnh chi tiết</option>`;
                $.each(resp.list_image, function (key, value) {
                    output += `<option value="${value.image}" data-left="http://localhost:8080/nadshop/${value.image}">${value.img_name}</option>`;
                });
                output += `</select></div></div></div></div></div></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="button" id="btn_save" name="btn_save" class="btn btn-primary">Lưu</button>
                            </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="url_product_detail" data-url ="${resp.url_add_product}" data-id="${resp.id_product}">`;
                $('.loadajax').css('display', 'none');
                $('#modalPopup').empty().html(output);
                $('.detail-modal').modal('show');

            }, error: function () {
                $('.loadajax').css('display', 'none');
                alert("error!!!!");
            }
        });
    });

    var COUNT_TAB_WORK = 1;
    $(document).on("click", "ul li a#add_work", function () {
        COUNT_TAB_WORK = COUNT_TAB_WORK + 1;
        var CONTENT_FORM = $(".tab-pane").html();
        var id = $(".nav-tabs").children().length;
        if (id <= 7) {
            var tabId = "p_" + id;
            $(this)
                .closest("li")
                .before(
                    `<li class="nav-item" role="presentation">
                        <a class="nav-link" id="${tabId}-tab" data-toggle="tab" href="#${tabId}" role="tab"
                            aria-selected="true">Product-${COUNT_TAB_WORK}</a>
                            <span class="remove-product-tab"><i class="fa fa-times" aria-hidden="true"></i>
                            </span>
                    </li>`
                );
            $(".tab-content").append(
                `<div class="tab-pane fade" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">${CONTENT_FORM}</div>`
            );
            $(".nav-tabs li:nth-child(" + id + ") a").click();
            addAttrForItem(tabId);
        }
    });

});

$(document).on("click", ".nav-tabs span", function () {
    var anchor = $(this).siblings('a');
    $(anchor.attr('href')).remove();
    $(this).parent().remove();
    $(".nav-tabs li").children('a').first().click();
});
function changeImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#avatar").attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function addAttrForItem(parentID) {
    $("#myModal #" + parentID + " .product_name").attr(
        "id",
        parentID + "_product_name"
    );
    $("#myModal #" + parentID + " .product_price").attr(
        "id",
        parentID + "_product_price"
    );
    $("#myModal #" + parentID + " .product_discount").attr(
        "id",
        parentID + "_product_discount"
    );
    $("#myModal #" + parentID + " .stock").attr("id", parentID + "_stock");
    $("#myModal #" + parentID + " .color").attr("id", parentID + "_color");
    $("#myModal #" + parentID + " .size_ver").attr(
        "id",
        parentID + "_size_ver"
    );
    $("#myModal #" + parentID + " .thumbnail").attr("id", parentID + "_select_image");
}
