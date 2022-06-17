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

function asset(param) {
    let path = window.location.origin + '/nadshop/' + param;
    return path;
}

function num_in_cart() {
    let num_in_cart = JSON.parse(localStorage.getItem('data_cart')).reduce(function (sum, current) {
        return sum + current.qty;
    }, 0);
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
    if (localStorage.getItem('data_cart') != null) {
        let show_data = JSON.parse(localStorage.getItem('data_cart'));
        if (show_data.length > 0) {
            let show_cart = render_to_html(show_data);
            $('.js-cart-product-template').html(show_cart);
        } else {
            let output = `<p class="cart__empty js-cart-empty">
                Chưa có sản phẩm nào trong giỏ hàng.
            </p>`;
            $('.js-cart-product-template').html(output);
        }

    }
}

function remove_item_cart(e) {
    e.preventDefault();
    let confirm_delete = confirm("Bạn có chắc chắn muốn xóa không?");
    if (confirm_delete == true) {
        let key = $(this).data('key');
        let old_data = JSON.parse(localStorage.getItem('data_cart'));
        old_data.splice(key);
        localStorage.setItem('data_cart', JSON.stringify(old_data));
        $("#product-" + key).remove();
        num_in_cart();
        show_cart_total();
        show_cart();
    }
}

function show_cart_total() {
    let total_cart = JSON.parse(localStorage.getItem('data_cart')).reduce(function (sum, current) {
        return sum + (current.qty * current.price);
    }, 0);
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

function test() {

}

