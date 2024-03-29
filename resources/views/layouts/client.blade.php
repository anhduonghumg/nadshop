<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NADSHOP</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="{{ url('public/client/img/favicon.ico') }}" rel="icon">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="{{ url('public/client/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ url('public/client/css/client.css') }}" rel="stylesheet">
    <link href="{{ url('public/client/css/account.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="{{ url('public/css/sweetalert2.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="{{ url('public/client/lib/easing/easing.min.js') }}"></script>
    <script src="{{ url('public/client/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- Contact Javascript File -->
    <script src="{{ url('public/client/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ url('public/client/mail/contact.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{ url('public/client/js/client.js') }}"></script>
    <script src="{{ url('public/client/js/pagination.js') }}"></script>
    <script src="{{ url('public/js/sweetalert2.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

</head>

<body>
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "111172065012648");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v14.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <style>
        .fb_dialog_content iframe {
            /* right: 1180px !important; */
        }

        .slick-carousel img {
            width: 200px;
        }

        .show_auto_search {
            position: absolute;
            z-index: 9999999999;
        }

        .show_auto_search ul {
            list-style: none;
            padding: 0px;
            background-color: #ffffff;
            width: 550px;
        }

        .show_auto_search ul li {
            display: flex;
            margin-left: 12px;
            padding-top: 10px;
            padding-bottom: 7px;
            border-bottom: 1px solid #eee;
        }

        .show_auto_search ul li .info {
            margin-left: 20px;
        }

        .info p.price {
            margin-top: 5px;
        }

        a.query-search {
            font-size: 13px;
            margin-left: 13px;
        }
    </style>
    <!-- Topbar Start -->
    <div id="wrapper">
        <div class="container-fluid">
            <div class="row bg-secondary py-2 px-xl-5">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-dark" href=""><i class="fa fa-phone mr-2"
                                aria-hidden="true"></i>0967692853</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-dark pl-2" href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center py-3 px-xl-5">
                <div class="col-lg-3 d-none d-lg-block">
                    <a href="{{ route('client.home') }}" class="text-decoration-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border px-3 mr-1">NAD</span>SHOP</h1>
                    </a>
                </div>
                <div class="col-lg-6 col-6 text-left">
                    <form action="{{ route('client.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control btn_search" id="search_value" name="key"
                                value="{{ request()->input('key') }}" placeholder="Tìm kiếm gì đó..."
                                autocomplete="off">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                    <div class="show_auto_search">

                    </div>
                </div>
                <div class="col-lg-3 col-6 text-right">
                    <a href="{{ route('client.product.wishlist') }}" class="btn border" title="Yêu thích">
                        <i class="fas fa-heart text-primary"></i>
                        <span class="wishlist_badge">0</span>
                    </a>
                    <a href="{{ route('client.cart.show') }}" class="btn border js-toggle-cart" title="Giỏ hàng">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        <span class="cart_badge">0</span>
                    </a>
                    <a href="{{ route('client.order.find') }}" class="btn border history_order"
                        title="Tra cứu đơn hàng">
                        <i class="fas fa-truck text-primary"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- Topbar End -->
        <!-- Nav start -->
        <div class="container-fluid">
            <div class="row border-top px-xl-5">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                        <a href="" class="text-decoration-none d-block d-lg-none">
                            <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                    class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                @foreach ($category_products as $cat)
                                    <div class="nav-item dropdown">
                                        @if ($cat->parent_id == 0)
                                            <a href="{{ Route('client.product.cat.show', $cat->id) }}"
                                                class="nav-link dropdown-toggle"
                                                data-toggle="dropdown">{{ $cat->category_product_name }}</a>
                                            <div class="dropdown-menu rounded-0 m-0">
                                                @foreach ($category_products as $cat2)
                                                    @if ($cat2->parent_id != 0 && $cat2->parent_id == $cat->id)
                                                        <a href="{{ route('client.product.cat.show', $cat2->id) }}"
                                                            class="nav-item nav-link">{{ $cat2->category_product_name }}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                {{-- <a href="" class="nav-item nav-link">Album</a> --}}
                                <a href="{{ route('client.news') }}" class="nav-item nav-link">Tin tức</a>
                            </div>
                            <div class="navbar-nav ml-auto py-0">
                                @if (request()->session()->get('client_login') == true)
                                    {{-- <a href="#" class="nav-item nav-link account"><i class="fa fa-user"
                                        aria-hidden="true"></i>
                                    {{ request()->session()->get('name') }}</a> --}}
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ request()->session()->get('client_name') }}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('client.profile') }}">Thông tin
                                                cá
                                                nhân</a>
                                            <a class="dropdown-item" href="{{ route('client.logout') }}">Đăng
                                                xuất</a>
                                        </div>
                                    </div>
                                @else
                                    <a href="#" class="nav-item nav-link account"><i class="fa fa-user"
                                            aria-hidden="true"></i>
                                        Tài
                                        khoản</a>
                                @endif
                                {{-- < a href="" class="nav-item nav-link">Đăng ký</> --}}
                                {{-- < span class='auth'><i class="fa fa-user" aria-hidden="true"></i></> --}}
                            </div>
                        </div>
                    </nav>
                    <div id="header-carousel" class="carousel slide" data-ride="carousel">
                        @yield('carousel')
                    </div>
                </div>
            </div>
        </div>
        <!-- Nav end -->

        <div class="wp-content">
            @yield('content')
        </div>

        <!-- Footer Start -->
        <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
            <div class="row px-xl-5 pt-5">
                <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                    <a href="" class="text-decoration-none">
                        <h1 class="mb-4 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border border-white px-3 mr-1">NAD</span>SHOP
                        </h1>
                    </a>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Về chúng tôi</h5>
                            <div class="d-flex flex-column justify-content-start">
                                <p>Công ty NADSHOP</p>
                                <p>Địa chỉ: 408 Cầu giấy,Phường Dịch vọng,Quận cầu giấy,Thành phố Hà Nội</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Hệ thống cửa hàng</h5>
                            <div class="d-flex flex-column justify-content-start">
                                <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>203
                                    Trần Cung</a>
                                <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>408
                                    Cầu giấy</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Đăng ký khuyến mãi</h5>
                            <form action="">
                                <div class="form-group">
                                    <input type="text" class="form-control border-0 py-4" placeholder="Your Name"
                                        required="required" />
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                        required="required" />
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe
                                        Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row border-top border-light mx-xl-5 py-4">
                <div class="col-md-6 px-xl-0">
                    <p class="mb-md-0 text-center text-md-left text-dark">
                        &copy; <a class="text-dark font-weight-semi-bold" href="#">Your Site Name</a>. All
                        Rights
                        Reserved.
                        Designed
                        by
                        <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a>
                    </p>
                </div>
                <div class="col-md-6 px-xl-0 text-center text-md-right">
                    <img class="img-fluid" src="" alt="">
                </div>
            </div>
        </div> --}}
            <!-- Footer End -->
            <!-- Back to Top -->
            <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
            <!-- Loading animation -->
            <div class="loading">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <div id="cd-shadow-layer"></div>
            <!-- sidebar cart -->
            <aside class="cart js-cart">
                <div class="cart__header">
                    <h4 class="cart__title">Giỏ hàng</h4>
                    <p class="cart__text">
                        <a class="button button--light js-toggle-cart" href="#" title="Close cart">
                            <i class="fas fa-times icon-close-cart"></i>
                        </a>
                    </p>
                </div>
                <div class="cart__products js-cart-products">
                    <div class="cart__product js-cart-product-template">
                        <article class="js-cart-product d-flex justify-content-between">
                            <div class="cart-img">
                                <img src="" alt="">
                            </div>
                            <div class="cart-info">
                                <p>Áo sơ mi dài tay</p>
                                <p>Giá: X<span class="item-qty">4</p>
                            </div>
                            <a href="remove-item"><i class="far fa-times-circle"></i></a>
                        </article>
                    </div>
                    <div class="cart__footer">
                        <div class="total-cart d-flex justify-content-between">
                            <p class="text-dark font-weight-semi-bold">Tổng tiền tạm tính:</p>
                            <p class="text-dark font-weight-semi-bold cart-total">20.000.000đ</p>
                        </div>
                        <a href="{{ route('client.cart.checkout') }}"
                            class="btn btn-dark btn-order d-block w-100">Tiến
                            hành
                            đặt hàng</a>
                        <a href="{{ route('client.cart.show') }}"
                            class="cart-detail d-block text-center mt-2 mb-2 text-dark">Xem chi tiết giỏ hàng</a>
                    </div>
                </div>
            </aside>
            <!-- end sidebar cart -->
            <div class="lightbox js-lightbox js-toggle-cart"></div>

            <!-- Modal Account Start -->
            <div class="modal fade login" id="loginModal">
                <div class="modal-dialog login animated">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Đăng nhập với</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="box">
                                <div class="content">
                                    <div class="social">
                                        <a id="google_login" class="circle google" href="#">
                                            <i class="fab fa-google"></i>
                                        </a>
                                        <a id="facebook_login" class="circle facebook" href="#">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    </div>
                                    <div class="division">
                                        <div class="line l"></div>
                                        <span>Hoặc</span>
                                        <div class="line r"></div>
                                    </div>
                                    <div class="error"></div>
                                    <div class="form loginBox">
                                        <form method="">
                                            <input id="email_login" class="form-control" type="text"
                                                placeholder="email" name="email">
                                            <input id="password_login" class="form-control" type="password"
                                                placeholder="Mật khẩu" name="password">
                                            <input class="btn btn-default btn-login" type="button"
                                                value="Đăng nhập">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="content registerBox" style="display:none;">
                                    <div class="form" id="">
                                        <form id="form_reg" method="" html="{:multipart=>true}"
                                            data-remote="true" action="" accept-charset="UTF-8">
                                            <input class="form-control" type="text" placeholder="Họ tên"
                                                name="fullname">
                                            <input class="form-control" type="text" placeholder="Số điện thọai"
                                                name="phone">
                                            <input class="form-control" type="text" placeholder="email"
                                                name="email">
                                            <input class="form-control" type="password" placeholder="Password"
                                                name="password">
                                            <input class="btn btn-default btn-register" type="button"
                                                value="Tạo tài khoản">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="forgot-pass-box">
                                <div class="content forgotPassBox" style="display:none;">
                                    <div class="form" id="">
                                        <form id="forgotPassBox" method="" html="{:multipart=>true}"
                                            data-remote="true" action="" accept-charset="UTF-8">
                                            <input class="form-control" type="email" placeholder="email"
                                                name="email">
                                            <input class="btn btn-primary btn-forgot-pass form-control mt-3"
                                                type="button" value="Xác nhận">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="forgot login-footer">
                                <p><a class='forgot_pass'>Quên mật khẩu</a>?</p>
                                <span><a href="" class='register'>Tạo một tài khoản</a>?</span>
                            </div>
                            <div class="forgot register-footer" style="display:none">
                                <span>Bạn đã có tài khoản?</span>
                                <a href="javascript: showLoginForm();">Đăng nhập</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Account End -->

        </div>

        <script type="text/javascript">
            num_in_cart();
            var total_wl = 0;
            if (localStorage.getItem('data_wishlist') == null) {
                total_wl = 0;
            } else {
                total_wl += JSON.parse(localStorage.getItem('data_wishlist')).length;
            }
            $('.wishlist_badge').html(total_wl);

            var cartOpen = false;
            var numberOfProducts = 0;

            $('body').on('click', '.js-toggle-cart', toggleCart);
            $('body').on('click', '.js-add-product', addProduct);
            $('body').on('click', '.btn-remove-item', remove_item_cart);
            $('body').on('click', '.btn-order', function(e) {
                if (localStorage.getItem('data_cart') === null || JSON.parse(localStorage.getItem('data_cart'))
                    .length <= 0) {
                    e.preventDefault();
                    window.location.href = "http://localhost/nadshop";
                } else {
                    return true;
                }
            });


            // autoComplete-search

            var myTimer = null;
            $('#search_value').keyup(function(e) {
                clearTimeout(myTimer);
                myTimer = setTimeout(function() {
                    var search_text = $("#search_value").val();
                    $.ajax({
                        url: "{{ route('client.searchAuto') }}",
                        type: "POST",
                        data: {
                            search_text: search_text
                        },
                        dataType: "json",
                        success: function(data) {
                            $('.show_auto_search').html(data);
                            if (search_text == '') {
                                $(".query-search").hide();
                            }
                        }
                    });
                }, 400);
            });


            // Login - Register
            $('body').on('click', '.account', function(e) {
                e.preventDefault();
                openLoginModal();
            });

            $('body').on('click', '.register', function(e) {
                e.preventDefault();
                openRegisterModal();
            });

            $('body').on('click', '.forgot_pass', function(e) {
                e.preventDefault();
                openForgotModal();
            });

            $('body').on('click', '.btn-login', function() {
                let email = $('#email_login').val();
                let password = $('#password_login').val();
                let current_url = window.location.href;
                $.ajax({
                    url: "{{ route('client.login') }}",
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                        current_url: current_url
                    },
                    dataType: "json",
                    success: function(rsp) {
                        if ($.isEmptyObject(rsp.errors)) {
                            window.location.href = rsp.success;
                        } else {
                            confirm_warning(rsp.errors);
                        }
                    },
                    error: function() {
                        alert("error!!!!");
                    }
                });
            });

            $('body').on('click', '.btn-forgot-pass', function() {
                let form_forgot = $('#forgotPassBox').serialize();
                $.ajax({
                    url: "{{ route('client.forgotPass') }}",
                    type: 'POST',
                    data: form_forgot,
                    dataType: "json",
                    success: function(rsp) {
                        if ($.isEmptyObject(rsp.errors)) {
                            confirm_success(rsp.success);
                        } else {
                            confirm_warning(rsp.errors);
                        }
                    },
                    error: function() {
                        alert("error!!!!");
                    }
                });
            });

            $('body').on('click', '.btn-register', function() {
                let form_reg = $("#form_reg").serialize();
                $.ajax({
                    url: "{{ route('client.register') }}",
                    type: 'POST',
                    data: form_reg,
                    dataType: "json",
                    success: function(rsp) {
                        if ($.isEmptyObject(rsp.errors)) {
                            confirm_success(rsp.success);
                        } else {
                            confirm_warning(rsp.errors);
                        }
                    },
                    error: function() {
                        alert("error!!!!");
                    }
                });
            });

            function openLoginModal() {
                showLoginForm();
                setTimeout(function() {
                    $('#loginModal').modal('show');
                }, 230);
            }

            function openRegisterModal() {
                showRegisterForm();
                setTimeout(function() {
                    $('#loginModal').modal('show');
                }, 230);

            }

            function openForgotModal() {
                showForgotForm();
                setTimeout(function() {
                    $('#loginModal').modal('show');
                }, 230);
            }

            function showLoginForm() {
                $('#loginModal .registerBox').fadeOut('fast', function() {
                    $('.forgotPassBox').fadeOut('fast');
                    $('.loginBox').fadeIn('fast');
                    $('.register-footer').fadeOut('fast', function() {
                        $('.login-footer').fadeIn('fast');
                    });
                    $('.modal-title').html('Login with');
                });
                $('.error').removeClass('alert alert-danger').html('');
            }

            function showForgotForm() {
                $('.loginBox').fadeOut('fast', function() {
                    $('.forgotPassBox').fadeIn('fast');
                    $('.login-footer').fadeOut('fast', function() {
                        $('.register-footer').fadeOut('fast');
                    });
                    $('.modal-title').html('Forgot Password');
                });
                $('.error').removeClass('alert alert-danger').html('');
            }

            function showRegisterForm() {
                $('.loginBox').fadeOut('fast', function() {
                    $('.registerBox').fadeIn('fast');
                    $('.login-footer').fadeOut('fast', function() {
                        $('.register-footer').fadeIn('fast');
                    });
                    $('.modal-title').html('Register with');
                });
                $('.error').removeClass('alert alert-danger').html('');
            }

            // end login - register

            function addProduct(e) {
                e.preventDefault();
                openCart();
                $('.js-cart-empty').addClass('hide');
                var product = $('.js-cart-product-template').html();
                $('.js-cart-products').prepend(product);
                numberOfProducts++;
            }

            // function get total price of cart
            function getTotalPrice() {
                var total = 0;
                $('.js-cart-product').each(function() {
                    var price = $(this).find('.item-price').text();
                    var qty = $(this).find('.item-qty').text();
                    total += price * qty;
                });
                return total;
            }


            /*
            $('.slick-carousel').slick({
                infinite: false,
                vertical: true,
                verticalSwiping: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                prevArrow: $('.top-arrow'),
                nextArrow: $('.bottom-arrow')
            });
            */

            /*
                  ============ Viewd ===========
                       $(document).on('click', '.btn_view', function (e) {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var price = $(this).data('price');
                var image = $(this).data('img');
                var url = $(this).data('url');
                var viewedItem = {
                    'id': id,
                    'url': url,
                    'name': name,
                    'price': price,
                    'image': image
                }
                if (localStorage.getItem('data_viewed') == null) {
                    localStorage.setItem('data_viewed', '[]');
                }

                var viewed = JSON.parse(localStorage.getItem('data_viewed'));
                var matches = $.grep(viewed, function (obj) {
                    return obj.id == id;
                });

                if (!matches.length) {
                    viewed.push(viewedItem);
                }

                localStorage.setItem('data_viewed', JSON.stringify(viewed));
            });
            */
        </script>
</body>

</html>
