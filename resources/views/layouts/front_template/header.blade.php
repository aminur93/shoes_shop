<header class="header-style-5" id="cart_item">
    <div class="mobile-fix-option"></div>
    <div class="top-header top-header-theme">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="header-contact">
                        <ul>
                            <li>Welcome to Our store Kites Bangladesh</li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i>Call Us: 01772119941</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 text-end">
                    <ul class="header-dropdown">

                        <li class="onhover-dropdown mobile-account"> <i class="fa fa-user" aria-hidden="true"></i>
                            @if(auth('customer')->user())
                                {{ auth('customer')->user()->name }}
                            @else
                            My Account
                            @endif

                            <ul class="onhover-show-div">
                                @if(auth('customer')->user())
                                    <li><a href="{{ route('customer.dashboard') }}">Profile</a></li>
                                    <li><a href="{{ route('customer_logout') }}">Logout</a></li>
                                @else
                                <li><a href="{{ route('customer.login') }}">Login</a></li>
                                <li><a href="{{ route('customer.register') }}">register</a></li>
                                @endif

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
                            <a href="{{ route('kites') }}"><img src="{{ asset('assets/admin/uploads/logo/original/'.$logo->logo_image) }}"
                                            class="img-fluid blur-up lazyload" alt="" width="179px" height="34px"></a>
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
                            <div class="icon-nav">
                                <ul>
                                    <li class="onhover-div mobile-search">
                                        <div><img src="{{ asset('assets/front_end/assets/images/icon/search.png') }}" onclick="openSearch()"
                                                  class="img-fluid blur-up lazyload" alt=""> <i class="ti-search"
                                                                                                onclick="openSearch()"></i></div>
                                        <div id="search-overlay" class="search-overlay">
                                            <div> <span class="closebtn" onclick="closeSearch()"
                                                        title="Close Overlay">×</span>
                                                <div class="overlay-content">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <form>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control"
                                                                               id="exampleInputPassword1"
                                                                               placeholder="Search a Product">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                                class="fa fa-search"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="onhover-div mobile-cart">
                                        <div><img src="{{ asset('assets/front_end/assets/images/icon/cart.png') }}"
                                                  class="img-fluid blur-up lazyload" alt=""> <i
                                                    class="ti-shopping-cart"></i></div>
                                        <span class="cart_qty_cls" id="cart_count"></span>
                                        <ul class="show-div shopping-cart">

                                            <div id="cart_data"></div>

                                            <li>
                                                <div class="buttons">
                                                    <a href="{{ route('cart') }}" class="view-cart">view cart</a>
                                                    <a href="#" class="checkout">checkout</a>
                                                </div>
                                            </li>

                                        </ul>
                                    </li>
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
                    <div id="toggle-sidebar" class="toggle-sidebar">
                        <i class="fa fa-bars sidebar-bar"></i>
                        <h5 class="mb-0">shop by category</h5>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="main-nav-center">
                        <nav id="main-nav" class="text-start">
                            <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                            <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                <li>
                                    <div class="mobile-back text-end">Back<i class="fa fa-angle-right ps-2"
                                                                             aria-hidden="true"></i></div>
                                </li>
                                <li><a href="">Home</a></li>
                                <li><a href="">About</a></li>
                                <li><a href="">Contact Us</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>