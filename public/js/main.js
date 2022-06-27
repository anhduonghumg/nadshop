
$(document).ready(function () {

    var COUNT_TAB_WORK = 1;
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

    $('#btn_search').attr('disabled', true);
    $('.keyword').keyup(function () {
        if ($(this).val().length != 0)
            $('#btn_search').attr('disabled', false);
        else
            $('#btn_search').attr('disabled', true);
    })

    // add product detail
    $(document).on("click", "#add_product_detail", function () {
        $('#selectThumb').ddslick();
        COUNT_TAB_WORK = 1;
        var url = $('#add_product_detail').attr('data-url');
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
                                        <form id="fm_detail_product" method="POST">
                                            <div class="modal-header ui-dranggale-handle" style="cursor: move;">
                                                <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết sản phẩm</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class='info-product my-3'>
                                             <strong for="">Tên sản phẩm gốc: </strong>
                                             <span>${resp.info_product.product_name}</span>
                                              </div>
                                            <ul class="nav nav-tabs mt-3 mb-3" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="p_1-tab" data-toggle="tab" href="#p_1" role="tab"
                                                        aria-selected="true">Tab</a>
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
                                                                    <input type="text" class="form-control product_detail_name"
                                                                        placeholder="Tên sản phẩm" name="product_detail_name[]">
                                                                        <p class="error_msg" id="product_detail_name"></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row ">
                                                            <label for="cost_price" class="col-sm-4 control-label">Giá nhập:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control cost_price"
                                                                    placeholder="Giá nhập sản phẩm (VNĐ)" name="cost_price[]">
                                                            </div>
                                                           </div>
                                                            <div class="form-group row ">
                                                                <label for="product_price" class="col-sm-4 control-label">Giá bán:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control product_price"
                                                                        placeholder="Giá bán sản phẩm (VNĐ)" name="product_price[]">
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
                                        <option value="" selected>Chọn màu</option>`;
                $.each(resp.list_product_color, function (key, value) {
                    output += `<option value="${value.id}">${value.color_name}</option>`;
                });
                output += `</select></div></div><div class="form-group row"><label for="size_ver" class="col-sm-4 control-label">Kích
                cỡ/bản:</label>
                <div class="col-sm-8">
                <select class="form-control size_ver" name="product_size[]">
                <option value="" selected>Chọn kích cỡ/phiên bản</option>`;
                $.each(resp.list_product_size, function (key, value) {
                    output += `<option value="${value.id}">${value.size_name}</option>`;
                });
                output += `</select></div></div></div>
                <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                <label for="" class="col-sm-4 control-label">Ảnh chi tiết:</label>
                <div class="col-sm-8">
                <select id="selectThumb" class="form-control thumbnail" name="product_details_thumb[]">
                        <option value="" selected>Chọn ảnh chi tiết</option>`;
                $.each(resp.list_image, function (key, value) {
                    output += `<option data-imagesrc="http://localhost:8080/nadshop/storage/app/public/images/product/thumb/${value.image}" value="${value.image}"></option>`;
                });
                output += `</select></div></div></div></div></div></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="Lưu">
                            </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="url_product_detail" data-url ="${resp.url_add_product}" data-id="${resp.id_product}">
                    <div class="print-error-msg">
                    <ul>
                    </ul>
                    </div>`;
                $('.loadajax').css('display', 'none');
                $('#modalPopup').empty().html(output);
                $('.detail-modal').modal('show');
                $('.thumbnail').ddslick();

            }, error: function () {
                $('.loadajax').css('display', 'none');
                alert("error!!!!");
            }
        });

    });



    // save product detail
    $(document).on('click', '#btn_save', function () {
        // $('.loadajax').show();
        var url_save = $('#url_product_detail').attr('data-url');
        // var fm_data = $('#fm_detail_product').serialize();
        var id = $('#url_product_detail').attr('data-id');
        var product_detail_name = [];
        var product_price = [];
        var product_color = [];
        var product_size = [];
        var product_details_thumb = [];
        var product_qty_stock = [];
        var product_discount = [];
        var cost_price = [];

        $(".product_detail_name").each(function () {
            product_detail_name.push($(this).val());
        });
        $(".cost_price").each(function () {
            cost_price.push($(this).val());
        });
        $(".product_price").each(function () {
            product_price.push($(this).val());
        });
        $(".product_discount").each(function () {
            product_discount.push($(this).val());
        });
        $(".stock").each(function () {
            product_qty_stock.push($(this).val());
        });
        $(".color").each(function () {
            product_color.push($(this).val());
        });
        $(".size_ver").each(function () {
            product_size.push($(this).val());
        });
        $(".thumbnail").each(function () {
            product_details_thumb.push($(this).val());
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log(product_size);
        // $.ajax({
        //     type: "POST",
        //     url: url_save,
        //     data: {
        //         id: id,
        //         product_detail_name: product_detail_name,
        //         product_price: product_price,
        //         product_color: product_color,
        //         product_size: product_size,
        //         product_details_thumb: product_details_thumb,
        //         product_qty_stock: product_qty_stock,
        //         product_discount: product_discount,
        //         cost_price: cost_price,
        //     },
        //     dataType: "json",
        //     success: function (data) {
        //         $('.loadajax').hide();
        //         if ($.isEmptyObject(data.errors)) {
        //             confirm_success(data.success);
        //             $('.close').click();
        //         } else {
        //             confirm_warning(data.errors);
        //         }
        //     }
        // });
    });

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
                            aria-selected="true">Tab - ${COUNT_TAB_WORK}</a>
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

    $(document).on("click", ".nav-tabs span", function () {
        var id = $("#myTab").children().length;
        var anchor = $(this).siblings('a');
        if (id > 2) {
            $(anchor.attr('href')).remove();
            $(this).parent().remove();
            $(".nav-tabs li").children('a').first().click();
        }
    });
});

function formatState(opt) {
    if (!opt.id) {
        return opt.text.toUpperCase();
    }

    var optimage = $(opt.element).attr('data-image');
    console.log(optimage)
    if (!optimage) {
        return opt.text.toUpperCase();
    } else {
        var $opt = $(
            '<span><img src="' + optimage + '" width="30px" /> ' + opt.text.toUpperCase() + '</span>'
        );
        return $opt;
    }
};

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

function confirm_warning(data) {
    Swal.fire({
        icon: 'warning',
        text: data
    });
}

function confirm_success(data) {
    Swal.fire({
        icon: "success",
        title: data,
        showConfirmButton: false,
        timer: 1500
    })
}

function confirm_delete() {
    Swal.fire({
        title: 'Bạn thật sự muốn xóa?',
        text: "Bạn không thể hoàn tác lại.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        confirmCancelText: "Hủy"
    });
}

function notification(icon = "success", data) {
    const Toast = Swal.mixin({
        showCloseButton: true,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
        icon: icon,
        title: data
    });
}

function custom_template(obj) {
    var data = $(obj.element).data();
    var text = $(obj.element).text();
    if (data && data['img_src']) {
        img_src = data['img_src'];
        template = $("<div><img src=\"" + img_src + "\" style=\"width:100%;height:150px;\"/><p style=\"font-weight: 700;font-size:14pt;text-align:center;\">" + text + "</p></div>");
        return template;
    }
}

function currencyFormat(val, unit = 'đ') {
    if (val != null) {
        return val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + unit;
    } else {
        return "";
    }
}

function dateFormat(string_date, dash) {
    if (string_date == null) {
        return '';
    }
    let date = new Date(string_date);
    let d = date.getUTCDate();
    let m = date.getUTCMonth() + 1;
    let y = date.getUTCFullYear();
    let h = date.getHours();
    let mi = date.getMinutes();

    return (d <= 9 ? '0' + d : d) + dash + (m <= 9 ? '0' + m : m) + dash + y + ' ' + (h <= 9 ? '0' + h : h) + ':' + mi;
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function locationUrl() {
    return $(location).attr('href');
}

function loadLocation() {
    let timeout = 1000;
    setTimeout(function () {
        window.location.reload();
    }, timeout)
}

function thumb_path(val) {
    if (val != null)
        return location.href + '/' + val;
}
