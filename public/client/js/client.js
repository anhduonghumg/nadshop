
(function ($) {
    "use strict";

    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // Vendor carousel
    $('.vendor-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 2
            },
            576: {
                items: 3
            },
            768: {
                items: 4
            },
            992: {
                items: 5
            },
            1200: {
                items: 6
            }
        }
    });

    // Related carousel
    $('.related-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            }
        }
    });

    //Product Quantity
    $(document).on('click', '.btn-plus', function () {
        $(this).parent().prev().val(Number($(this).parent().prev().val()) + 1).trigger('input');
    });

    $(document).on('click', '.btn-minus', function () {
        $(this).parent().next().val(Math.max(Number($(this).parent().next().val()) - 1, 1)).trigger('input');
    });

})(jQuery);



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

function asset(param) {
    let path = window.location.origin + '/nadshop/' + param;
    return path;
}

function num_in_cart() {
    let num_in_cart;
    if (localStorage.getItem('data_cart') === null) {
        num_in_cart = 0;
    } else {
        num_in_cart = JSON.parse(localStorage.getItem('data_cart')).reduce(function (sum, current) {
            return sum + current.qty;
        }, 0);
    }
    $('.cart_badge').html(num_in_cart);
}

function toggleCart(e) {
    e.preventDefault();
    if (cartOpen) {
        closeCart();
        return;
    }
    openCart();
}

function openCart() {
    cartOpen = true;
    show_cart();
    show_cart_total();
    $('body').addClass('open');
}

function closeCart() {
    cartOpen = false;
    $('body').removeClass('open');
}

function show_cart() {
    let output = '';
    if (localStorage.getItem('data_cart') != null) {
        let show_data = JSON.parse(localStorage.getItem('data_cart'));
        if (show_data.length > 0) {
            let show_cart = render_to_html(show_data);
            $('.js-cart-product-template').html(show_cart);
        } else {
            output = `<p class="cart__empty js-cart-empty">
                Chưa có sản phẩm nào trong giỏ hàng.
            </p>`;
            $('.js-cart-product-template').html(output);
        }

    } else {
        output = `<p class="cart__empty js-cart-empty">
        Chưa có sản phẩm nào trong giỏ hàng.
    </p>`;
        $('.js-cart-product-template').html(output);
    }
}

function remove_item_cart(e) {
    e.preventDefault();
    let confirm_delete = confirm("Bạn có chắc chắn muốn xóa không?");
    if (confirm_delete == true) {
        let key = Number($(this).data('key'));
        let old_data = JSON.parse(localStorage.getItem('data_cart'));
        old_data.splice(key, 1);
        localStorage.setItem('data_cart', JSON.stringify(old_data));
        $("#product-" + key).remove();
        num_in_cart();
        show_cart_total();
        show_cart();
    }
}

function show_cart_total() {
    let total_cart;
    if (localStorage.getItem('data_cart') === null) {
        total_cart = 0;
    } else {
        total_cart = JSON.parse(localStorage.getItem('data_cart')).reduce(function (sum, current) {
            return sum + (current.qty * current.price);
        }, 0);
    }
    $('.cart-total').html(currencyFormat(total_cart));
}

function render_to_html(data) {
    let output = '';
    $.each(data, function (key, value) {
        let price = currencyFormat(value.price);
        let path_img = asset(value.thumbnail);
        output += `<article class="js-cart-product d-flex justify-content-between" id="product-${key}">
            <div class="cart-img">
                <img src="${path_img}" alt="" with="100px" height="150px">
            </div>
            <div class="cart-info mt-4">
                <p class="text-dark">${value.name}</p>
                <p class="text-dark">${price} x<span class="item-qty text-dark font-italic">${value.qty}</p>
            </div>
            <a class="btn-remove-item" data-key="${key}"><i class="far fa-times-circle icon-remove-item"></i></a>
        </article>`;
    });
    return output;
}


function stringToNumber(data) {
    var result;
    if (data != null) {
        result = data.substring(0, data.length - 1);
        result = result.replace(/\./g, '');
    }
    return result;
}

function convertStatusOrder(data) {
    if (data == 'pending') {
        return "Chờ xác nhận";
    } else if (data == 'shipping') {
        return "Đang vận chuyển";
    } else if (data == 'success') {
        return "Thành công";
    } else {
        return 'Hủy bỏ';
    }
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
