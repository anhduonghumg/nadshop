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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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

</head>

<body>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <style>
        .slick-carousel img {
            width: 200px;
        }
    </style>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Support</a>
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
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="{{ route('client.product.wishlist') }}" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="wishlist_badge">0</span>
                </a>
                <a href="{{ route('client.cart.show') }}" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="cart_badge">0</span>
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
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            @foreach ($category_products as $cat)
                            <div class="nav-item dropdown">
                                @if($cat->parent_id == 0)
                                <a href="{{ Route('client.product.cat.show',$cat->id) }}"
                                    class="nav-link dropdown-toggle" data-toggle="dropdown">{{
                                    $cat->category_product_name }}</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    @foreach ($category_products as $cat2)
                                    @if($cat2->parent_id !=0 && $cat2->parent_id == $cat->id)
                                    <a href="{{ route('client.product.cat.show',$cat2->id) }}"
                                        class="nav-item nav-link">{{
                                        $cat2->category_product_name }}</a>
                                    @endif
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endforeach
                            <a href="" class="nav-item nav-link">Album</a>
                            <a href="" class="nav-item nav-link">Tin tức</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="#" class="nav-item nav-link account"><i class="fa fa-user" aria-hidden="true"></i>
                                Tài
                                khoản</a>
                            {{-- <a href="" class="nav-item nav-link">Đăng ký</a> --}}
                            {{-- <span class='auth'><i class="fa fa-user" aria-hidden="true"></i></span> --}}
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

    {{-- viewed --}}
    {{-- <div id="phistory-bar" class="hidden-xs hidden-sm tp_product_detail_history">
        <div class="phistor-icon"><i class="fa fa-angle-double-left"></i></div>
        <div class="phistory-title">Đã xem</div>
        <div class="phistory-content">
            <div class="phis-v-box">
                <div class="caroufredsel_wrapper"
                    style="display: block; text-align: start; float: none; position: relative; inset: auto; z-index: auto; width: 96px; height: 258px; margin: 0px; overflow: hidden;">
                    <div class="phistor-v-slider"
                        style="text-align: left; float: none; position: absolute; inset: 0px auto auto 0px; margin: 0px; height: 1118px; width: 96px;">
                        <div class="phistory-v-item" style="">
                            <a href="/quan-au-dang-ngan-xan-gau-slimfit-0104-p37513776.html"
                                title="Quần Âu Dáng Ngắn Xắn Gấu Slimfit 0104">
                                <img src="https://mcdn.nhanh.vn/store/662/ps/20220610/QA0104__8__thumb.jpg"
                                    alt="Quần Âu Dáng Ngắn Xắn Gấu Slimfit 0104">
                            </a>
                        </div>
                        <div class="phistory-v-item" style="">
                            <a href="/ao-phong-regular-cotton-0092-p37503956.html" title="Áo Phông Regular Cotton 0092">
                                <img src="https://mcdn.nhanh.vn/store/662/ps/20220601/AP0092__3__thumb.jpg"
                                    alt="Áo Phông Regular Cotton 0092">
                            </a>
                        </div>
                        <div class="phistory-v-item" style="">
                            <a href="/ao-phong-regular-cotton-0091-p37503947.html" title="Áo Phông Regular Cotton 0091">
                                <img src="https://mcdn.nhanh.vn/store/662/ps/20220601/AP0091__11__thumb.jpg"
                                    alt="Áo Phông Regular Cotton 0091">
                            </a>
                        </div>
                        <div class="phistory-v-item" style="">
                            <a href="/giay-sneaker-vai-0089-p37502808.html" title="Giày Sneaker Vải 0089">
                                <img src="https://mcdn.nhanh.vn/store/662/ps/20220607/GN0089__1__thumb.jpg"
                                    alt="Giày Sneaker Vải 0089">
                            </a>
                        </div>
                        <div class="phistory-v-item" style="">
                            <a href="/ao-so-mi-co-tau-tay-dai-regular-dui-0088-p37502771.html"
                                title="Áo Sơ Mi Cổ Tàu Tay Dài Regular Đũi 0088">
                                <img src="https://mcdn.nhanh.vn/store/662/ps/20220601/SM0088__5__thumb.jpg"
                                    alt="Áo Sơ Mi Cổ Tàu Tay Dài Regular Đũi 0088">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="phistor-v-nav">
                    <div class="prevSlideZ" style="display: block;"><i class="fa fa-chevron-up"></i></div>
                    <div class="nextSlideZ" style="display: block;"><i class="fa fa-chevron-down"></i></div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- end viewed --}}

    <div class="wp-content">
        @yield('content');
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border border-white px-3 mr-1">E</span>Shopper</h1>
                </a>
                <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna
                    ipsum
                    dolore amet erat.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York,
                    USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our
                                Shop</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop
                                Detail</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping
                                Cart</a>
                            <a class="text-dark mb-2" href="checkout.html"><i
                                    class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact
                                Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our
                                Shop</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop
                                Detail</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping
                                Cart</a>
                            <a class="text-dark mb-2" href="checkout.html"><i
                                    class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact
                                Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
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
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">Your Site Name</a>. All Rights
                    Reserved.
                    Designed
                    by
                    <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <!-- Loading animation -->
    <div class="loading">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
    <script type="text/javascript">
        num_in_cart();
        var total_wl = 0;
       if(localStorage.getItem('data_wishlist') == null){
           total_wl = 0;
       }else{
           total_wl += JSON.parse(localStorage.getItem('data_wishlist')).length;
       }
       $('.wishlist_badge').html(total_wl);


       /*
       $('.slick-carousel').slick({
        infinite: false,
        vertical:true,
        verticalSwiping:true,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow: $('.top-arrow'),
        nextArrow: $('.bottom-arrow')
      });
      */

      /*
      ============ Viewd ===========
       $(document).on('click','.btn_view',function(e){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');
        var image = $(this).data('img');
        var url  = $(this).data('url');
        var viewedItem = {
            'id' : id,
            'url' : url,
            'name' : name,
            'price' : price,
            'image' : image
        }
           if(localStorage.getItem('data_viewed') == null){
               localStorage.setItem('data_viewed','[]');
           }

           var viewed = JSON.parse(localStorage.getItem('data_viewed'));
           var matches = $.grep(viewed,function(obj){
              return obj.id == id;
           });

           if(!matches.length){
               viewed.push(viewedItem);
           }

           localStorage.setItem('data_viewed',JSON.stringify(viewed));
       });
       */
    </script>
</body>

</html>
