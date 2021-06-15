<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="multikart">
    <meta name="keywords" content="multikart">
    <meta name="author" content="multikart">
    <link rel="icon" href="{{ asset('assets/front_end/assets/images/favicon/23.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/front_end/assets/images/favicon/23.png') }}" type="image/x-icon">
    <title>Kites Banfladesh</title>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Yellowtail&amp;display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/fontawesome.css') }}">

    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/slick-theme.css') }}">

    <!-- Animate icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/animate.css') }}">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/themify-icons.css') }}">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/bootstrap.css') }}">

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/style.css') }}">

    @stack('css')

</head>

<body class="theme-color-11">


<!-- loader start -->
<div class="loader_skeleton">
    <header class="header-style-5">
        <div class="top-header top-header-theme">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="header-contact">
                            <ul>
                                <li>Welcome to Our store Multikart</li>
                                <li><i class="fa fa-phone" aria-hidden="true"></i>Call Us: 123 - 456 - 7890</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 text-end">
                        <ul class="header-dropdown">
                            <li class="mobile-wishlist"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a>
                            </li>
                            <li class="onhover-dropdown mobile-account"> <i class="fa fa-user" aria-hidden="true"></i>
                                My Account
                                <ul class="onhover-show-div">
                                    <li><a href="login.html">Login</a></li>
                                    <li><a href="register.html">register</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-menu">
                        <div class="menu-left">
                            <div class="navbar d-block d-xl-none">
                                <a href="javascript:void(0)" id="toggle-sidebar-res">
                                    <div class="bar-style"><i class="fa fa-bars sidebar-bar" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="brand-logo">
                                <a href="index.html"><img src="../assets/images/icon/logo/7.png"
                                                          class="img-fluid blur-up lazyload" alt=""></a>
                            </div>
                        </div>
                        <div>
                            <form class="form_search" role="form">
                                <input id="query search-autocomplete" type="search"
                                       placeholder="Search any Vegetable or Grocery..." class="nav-search nav-search-field"
                                       aria-expanded="true">
                                <button type="submit" name="nav-submit-button" class="btn-search">
                                    <i class="ti-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="menu-right pull-right">
                            <div>
                                <div class="icon-nav d-none d-sm-block">
                                    <ul>
                                        <li class="onhover-div mobile-search">
                                            <div><img src="../assets/images/icon/search.png" onclick="openSearch()"
                                                      class="img-fluid blur-up lazyload" alt=""> <i class="ti-search"
                                                                                                    onclick="openSearch()"></i></div></li>
                                        <li class="onhover-div mobile-setting">
                                            <div><img src="../assets/images/icon/setting.png"
                                                      class="img-fluid blur-up lazyload" alt=""> <i
                                                        class="ti-settings"></i></div></li>
                                        <li class="onhover-div mobile-cart">
                                            <div><img src="../assets/images/icon/cart.png"
                                                      class="img-fluid blur-up lazyload" alt=""> <i
                                                        class="ti-shopping-cart"></i></div>
                                            <span class="cart_qty_cls">2</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-part">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 category-menu d-none d-xl-block">
                        <div class="toggle-sidebar">
                            <i class="fa fa-bars sidebar-bar"></i>
                            <h5 class="mb-0">shop by category</h5>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="main-nav-center">
                            <nav class="text-start">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <ul class="sm pixelstrap sm-horizontal">
                                    <li>
                                        <div class="mobile-back text-end">Back<i class="fa fa-angle-right ps-2"
                                                                                 aria-hidden="true"></i></div>
                                    </li>
                                    <li><a href="index.html">Home</a></li>
                                    <li class="mega" >
                                        <a href="#">feature <div class="lable-nav">new</div></a></li>
                                    <li><a href="#">shop</a> </li>
                                    <li><a href="#">product</a></li>
                                    <li><a href="#">pages</a></li>
                                    <li><a href="#">blog</a> </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="small-section pt-res-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-3">
                    <div class="sidenav marketplace-sidebar svg-icon-menu">
                        <nav>
                            <div>
                                <div class="sidebar-back text-start d-xl-none d-block"><i class="fa fa-angle-left pe-2"
                                                                                          aria-hidden="true"></i> Back</div>
                            </div>
                            <ul class="sm pixelstrap sm-vertical">
                                <li><a href="#"><div class="ldr-img-icon"></div><div class="ldr-text"></div></a></li>
                                <li><a href="#"><div class="ldr-img-icon"></div><div class="ldr-text"></div></a></li>
                                <li><a href="#"><div class="ldr-img-icon"></div><div class="ldr-text"></div></a></li>
                                <li><a href="#"><div class="ldr-img-icon"></div><div class="ldr-text"></div></a></li>
                                <li><a href="#"><div class="ldr-img-icon"></div><div class="ldr-text"></div></a></li>
                                <li><a href="#"><div class="ldr-img-icon"></div><div class="ldr-text"></div></a></li>
                                <li><a href="#"><div class="ldr-img-icon"></div><div class="ldr-text"></div></a></li>
                                <li><a href="#"><div class="ldr-img-icon"></div><div class="ldr-text"></div></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-9">
                    <section class="pt-0 small-slider">
                        <div class="home-slider">
                            <div class="home"></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <section class="service-w-bg tools-service  pt-0">
        <div class="container">
            <div class="service p-0 ">
                <div class="row margin-default">
                    <div class="col-xl-3 col-sm-6 service-block">
                        <div class="media">
                            <svg class="bg-white"></svg>
                            <div class="media-body">
                                <h4></h4>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 service-block">
                        <div class="media">
                            <svg class="bg-white"></svg>
                            <div class="media-body">
                                <h4></h4>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 service-block">
                        <div class="media">
                            <svg class="bg-white"></svg>
                            <div class="media-body">
                                <h4></h4>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 service-block">
                        <div class="media">
                            <svg class="bg-white"></svg>
                            <div class="media-body">
                                <h4></h4>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- loader end -->


<!-- header start -->
@include('layouts.front_template.header')
<!-- header end -->

@yield('content')

<!-- footer start -->
@include('layouts.front_template.foorter')
<!-- footer end -->


<!--modal popup start-->
<div class="modal fade bd-example-modal-lg theme-modal" id="exampleModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body modal1">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="modal-bg">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="offer-content"> <img src="{{ asset('assets/front_end/assets/images/Offer-banner.png') }}"
                                                                 class="img-fluid blur-up lazyload" alt="">
                                    <h2>newsletter</h2>
                                    <form
                                            action="https://pixelstrap.us19.list-manage.com/subscribe/post?u=5a128856334b598b395f1fc9b&amp;id=082f74cbda"
                                            class="auth-form needs-validation" method="post"
                                            id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form"
                                            target="_blank">
                                        <div class="form-group mx-sm-3">
                                            <input type="email" class="form-control" name="EMAIL" id="mce-EMAIL"
                                                   placeholder="Enter your email" required="required">
                                            <button type="submit" class="btn btn-solid"
                                                    id="mc-submit">subscribe</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--modal popup end-->


<!-- Quick-view modal popup start-->
<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img src="{{ asset('assets/front_end/assets/images/pro3/1.jpg') }}" alt=""
                                                         class="img-fluid blur-up lazyload"></div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <h2>Women Pink Shirt</h2>
                            <h3>$32.96</h3>
                            <ul class="color-variant">
                                <li class="bg-light0"></li>
                                <li class="bg-light1"></li>
                                <li class="bg-light2"></li>
                            </ul>
                            <div class="border-product">
                                <h6 class="product-title">product details</h6>
                                <p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium
                                    doloremque laudantium</p>
                            </div>
                            <div class="product-description border-product">
                                <div class="size-box">
                                    <ul>
                                        <li class="active"><a href="javascript:void(0)">s</a></li>
                                        <li><a href="javascript:void(0)">m</a></li>
                                        <li><a href="javascript:void(0)">l</a></li>
                                        <li><a href="javascript:void(0)">xl</a></li>
                                    </ul>
                                </div>
                                <h6 class="product-title">quantity</h6>
                                <div class="qty-box">
                                    <div class="input-group"><span class="input-group-prepend"><button type="button"
                                                                                                       class="btn quantity-left-minus" data-type="minus" data-field=""><i
                                                        class="ti-angle-left"></i></button> </span>
                                        <input type="text" name="quantity" class="form-control input-number"
                                               value="1"> <span class="input-group-prepend"><button type="button"
                                                                                                    class="btn quantity-right-plus" data-type="plus" data-field=""><i
                                                        class="ti-angle-right"></i></button></span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-buttons"><a href="#" class="btn btn-solid">add to cart</a> <a
                                        href="#" class="btn btn-solid">view detail</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quick-view modal popup end--


<!-- tap to top -->
<div class="tap-top top-cls">
    <div>
        <i class="fa fa-angle-double-up"></i>
    </div>
</div>
<!-- tap to top end -->


<!-- latest jquery-->
<script src="{{ asset('assets/front_end/assets/js/jquery-3.3.1.min.js') }}"></script>

<!-- slick js-->
<script src="{{ asset('assets/front_end/assets/js/slick.js') }}"></script>
<script src="{{ asset('assets/front_end/assets/js/slick-animation.min.js') }}"></script>

<!-- menu js-->
<script src="{{ asset('assets/front_end/assets/js/menu.js') }}"></script>

<!-- lazyload js-->
<script src="{{ asset('assets/front_end/assets/js/lazysizes.min.js') }}"></script>

<!-- Timer js-->
<script src="{{ asset('assets/front_end/assets/js/timer.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('assets/front_end/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Bootstrap Notification js-->
<script src="{{ asset('assets/front_end/assets/js/bootstrap-notify.min.js') }}"></script>

<!-- Theme js-->
<script src="{{ asset('assets/front_end/assets/js/theme-setting.js') }}"></script>
<script src="{{ asset('assets/front_end/assets/js/script.js') }}"></script>
<script src="{{ asset('assets/front_end/assets/js/custom-slick-animated.js') }}"></script>


<script>
    $(window).on('load', function () {
        setTimeout(function () {
            $('#exampleModal').modal('show');
        }, 2500);
    });
    function openSearch() {
        document.getElementById("search-overlay").style.display = "block";
    }

    function closeSearch() {
        document.getElementById("search-overlay").style.display = "none";
    }
</script>

@stack('js')

</body>

</html>