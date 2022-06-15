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

function num_in_cart(){
    let num_in_cart = JSON.parse(localStorage.getItem('data_cart')).reduce(function(sum, current) {
        return sum + current.qty;
      }, 0);
      $('.cart_badge').html(num_in_cart);
}
