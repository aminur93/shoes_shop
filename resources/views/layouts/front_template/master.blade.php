<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="multikart">
    <meta name="keywords" content="multikart">
    <meta name="author" content="multikart">

    <link rel="icon" href="{{ asset('assets/front_end/assets/images/favicon/23.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/front_end/assets/images/favicon/23.png') }}" type="image/x-icon">
    <title>Kites Bangladesh</title>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Yellowtail&amp;display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/slick.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/slick-theme.css') }}">

    <!-- Animate icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/animate.css') }}">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/vendors/bootstrap.css') }}">

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front_end/assets/css/style.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    @stack('css')

</head>

<body class="theme-color-11">

<!-- header start -->
@include('layouts.front_template.header')
<!-- header end -->

@yield('content')

<!-- footer start -->
@include('layouts.front_template.foorter')
<!-- footer end -->

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
{{--<script src="{{ asset('assets/front_end/assets/js/timer.js') }}"></script>--}}

<!-- Bootstrap js-->
<script src="{{ asset('assets/front_end/assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/front_end/assets/js/script.js') }}"></script>

<script src="{{ asset('assets/front_end/assets/js/custom-slick-animated.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


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

<script>
    $(document).ready(function () {

        var session_id = sessionStorage.getItem('cart_token');

        $.ajax({
            url : "{{ route('get_cart') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "get",
            data: {session_id:session_id},
            dataType: "json",
            success: function (data) {

                if (data.cart === '')
                {
                    $("#cart_data").append('<p>Cart is Empty</p>')
                }else {
                    var cartItem = data.cart;

                    var cartData = '';

                    $.each(cartItem, function (key, value) {
                        cartData +=
                            '<li id="cart_details">'+
                            '<div class="media">'+
                            '<a href="#"><img alt="" class="me-3" src="http://localhost:8000/assets/admin/uploads/product/small/'+value.image+'"></a>'+
                            '<div class="media-body">'+
                            '<a href="#">'+
                            '<h4>'+value.product_title+'</h4>'+
                            '</a>'+
                            '<h4><span>'+value.product_quantity+' x  &#2547; '+value.price+'</span></h4>'+
                            '</div>'+
                            '</div>'+
                            '<div class="close-circle"><a href="#"><i class="fa fa-times"aria-hidden="true"></i></a></div>'+
                            '</li>'
                    });

                    $("#cart_data").append(
                        cartData+''+
                        '<li>'+
                        '<div class="total">'+
                        '<h5>subtotal : <span> &#2547; '+data.sub_total+'</span></h5>'+
                        '</div>'+
                        '</li>'
                    )

                    $("#cart_count").append(data.cart_total);
                }


            }
        })
    });

</script>


@stack('js')

</body>

</html>