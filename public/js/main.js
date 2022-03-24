$(document).ready(function () {
    var COUNT_TAB_WORK = 1;
    var CONTENT_FORM = $(".tab-pane").html();

    $(".nav-link.active .sub-menu").slideDown();
    // $("p").slideUp();

    $("#sidebar-menu .arrow").click(function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });

    $(".alert")
        .fadeTo(2000, 500)
        .slideUp(500, function () {
            $("#success-alert").slideUp(500);
        });
    $("#avatar").click(function () {
        $("#img").click();
    });

    $("ul li a#add_work").click(function () {
        COUNT_TAB_WORK = COUNT_TAB_WORK + 1;
        var id = $(".nav-tabs").children().length;
        if (id <= 9) {
            var tabId = "no_" + id;
            $(this)
                .closest("li")
                .before(
                    `<li class='nav-item'><a class='nav-link' id='${tabId}' data-toggle='tab'href='#${tabId}' role='tab'aria-controls='${tabId}' aria-selected='true'>Product-${COUNT_TAB_WORK}</a><span><i class="fa fa-times" aria-hidden="true"></i></span></li>`
                );
            $(".tab-content").append(
                `<div class="tab-pane fade" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}"> ${CONTENT_FORM} </div>`
            );
            $(".nav-tabs li:nth-child(" + id + ") a").click();
            addAttrForItem(tabId);
        }
        return false;
    });
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
    $("#modal-id-lg #" + parentID + " .product_name").attr(
        "id",
        parentID + "_product_name"
    );
    $("#modal-id-lg #" + parentID + " .product_type").attr(
        "id",
        parentID + "_product_type"
    );
    $("#modal-id-lg #" + parentID + " .product_price").attr(
        "id",
        parentID + "_product_price"
    );
    $("#modal-id-lg #" + parentID + " .product_discount").attr(
        "id",
        parentID + "_product_discount"
    );
    $("#modal-id-lg #" + parentID + " .stock").attr("id", parentID + "_stock");
    $("#modal-id-lg #" + parentID + " .color").attr("id", parentID + "_color");
    $("#modal-id-lg #" + parentID + " .size_ver").attr(
        "id",
        parentID + "_size_ver"
    );
    $("#modal-id-lg #" + parentID + " .img").attr("id", parentID + "_img");
}
