@extends('layouts.front_template.master')

@section('page')
    Product Details
@endsection

@push('css')
@endpush

@section('content')
    <input type="hidden" id="product_id" value="{{ $product->id }}">
    <?php $session_id = rand(1111,9999); ?>
    <input type="hidden" id="session_id" value="{{ $session_id }}">

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>Kites Bangladesh</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('kites') }}">Home / </a></li>

                            <li class="">{{ $product->name }}</li>

                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!-- section start -->
    <section>
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">

                        <div class="product-slick">
                            <div id="new_image">
                                <img src="{{ asset('assets/admin/uploads/product/original/'.$product->image) }}" alt="" class="img-fluid baseImage">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 p-0">
                                <img src="{{ asset('assets/admin/uploads/product/original/'.$product->image) }}" style="display: inline-block;float: left;margin-right: 10px;margin-left: 12px" alt="" class="img-fluid getUrl" width="100px">
                                @forelse($product_gallery as $pg)
                                <div>
                                    <img src="{{ asset('assets/admin/uploads/product_gallery/medium/'.$pg->gallery_image) }}" style="display: inline-block;float: left;margin-right: 10px;margin-left: 12px" class="getUrl img-fluid" alt="" width="100px">
                                </div>
                                @empty
                                <div>No Image found</div>
                                @endforelse

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">

                            <h2 id="product_title" rel1="{{ $product->name }}">{{ $product->name }}</h2>

                            <h3 class="price-detail" id="price" rel="{{ $product->price }}">&#2547; {{ $product->price }}</h3>


                            <div id="selectSize" class="addeffect-section product-description border-product">
                                <h6 class="product-title size-text">select size </h6>

                                <div class="size-box">
                                    <select name="product_size" id="product_size" class="form-control product_size" style="width: 150px">
                                        <option value="">Chose Size</option>
                                        @forelse($product_stock as $ps)
                                            <option value="{{ $ps->id }}">{{ $ps->size }}</option>
                                            @empty
                                            <option value="">No size found</option>
                                            @endforelse
                                    </select>
                                </div>

                                <h6 class="product-title">quantity</h6>
                                <div class="qty-box" id="size_quantity">
                                    <select name="product_quantity" id="product_quantity" class="form-control" style="width: 150px">
                                        <option value="">Chose Quantity</option>
                                    </select>
                                </div>

                            </div>

                            <div class="product-buttons" style="margin-left: -9px">
                                <a href="javascript:void(0)" id="cartEffect" class="btn btn-solid hover-solid btn-animation">
                                    <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i>
                                    add to cart
                                </a>
                            </div>

                            <div class="product-count">
                                <ul>
                                    <li>
                                        <img src="{{ asset('assets/front_end/assets/images/icon/truck.png') }}" class="img-fluid" alt="image">
                                        <span class="lang"> shipping for orders in dhaka above  &#2547; 50 Taka</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="border-product">
                                <h6 class="product-title">shipping info</h6>
                                <ul class="shipping-info">
                                    <li>100% Original Products</li>
                                    <li>Free Delivery on order above Rs. 799</li>
                                    <li>Pay on delivery is available</li>
                                    <li>Easy 30 days returns and exchanges</li>
                                </ul>
                            </div>

                            <div class="border-product">
                                <h6 class="product-title">100% secure payment</h6>
                                <img src="{{ asset('assets/front_end/assets/images/payment.png') }}" class="img-fluid mt-1" alt="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->


    <!-- product-tab starts -->
    <section class="tab-product m-0">
        <div class="container">
            <div class="row">

                <div class="col-sm-12 col-lg-12">

                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-selected="true"><i class="icofont icofont-ui-home"></i>Details</a>
                            <div class="material-border"></div>
                        </li>
                    </ul>

                    <div class="tab-content nav-material" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-home" role="tabpanel"
                             aria-labelledby="top-home-tab">
                            <div class="product-tab-discription">
                                <div class="part">
                                    <p>{!! $product->description !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-tab ends -->


    <!-- product section start -->
    <section class="section-b-space ratio_asos">
        <div class="container">
            <div class="row">
                <div class="col-12 product-related">
                    <h2>related products</h2>
                </div>
            </div>
            <div class="row search-product">
                @forelse($related_product as $rp)
                <div class="col-xl-2 col-md-4 col-6">
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="#"><img src="{{ asset('assets/admin/uploads/product/original/'.$rp->image) }}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="back">
                                <a href="#"><img src="{{ asset('assets/admin/uploads/product/original/'.$rp->image) }}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>

                        </div>
                        <div class="product-detail">
                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                            <a href="{{ route('details','') }}/{{ $rp->id }}">
                                <h6>{{ $rp->name }}</h6>
                            </a>
                            <h4>&#2547; {{ $rp->price }}</h4>
                            <ul class="color-variant">
                                <li class="bg-light0"></li>
                                <li class="bg-light1"></li>
                                <li class="bg-light2"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-md-12">No Related Found</div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- product section end -->
@endsection

@push('js')
<script>

    $(document).on("change",".product_size", function (e) {
        e.preventDefault();

        var product_id = $("#product_id").val();

        var product_size_id = $(this).val();

        $.ajax({
            type: "post",
            url: "{{ route('get_quantity') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {product_id:product_id,product_size_id:product_size_id},
            dataType: "html",
            success: function (html) {
                $("#product_quantity").html(html);
            }
        })
    });

    $(document).on("click", ".getUrl", function (e) {
        e.preventDefault();

        var image = $(this).attr('src');

        $(".baseImage").attr('src',image);
    })


    $(document).on("click","#cartEffect", function (e) {
            e.preventDefault();

            var product_id = $("#product_id").val();

            if (sessionStorage.getItem('cart_token') !== null)
            {
                var session_id = sessionStorage.getItem('cart_token');
            }else {
                var session_id = $("#session_id").val();
            }

            var product_title = $("#product_title").attr('rel1');
            var price = $("#price").attr('rel');
            var product_quantity = $("#product_quantity").val();
            var product_size = $("#product_size").val();

            $.ajax({
                url : "{{ route('add_to_cart') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                data: {product_id:product_id, session_id:session_id, product_title:product_title, price:price, product_quantity:product_quantity, product_size:product_size},
                dataType: "json",
                success: function (data) {

                    if (sessionStorage.getItem('cart_token') === null){
                        sessionStorage.setItem('cart_token',session_id);
                    }

                    if(data.flash_message_success) {

                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            },
                        toastr.success(data.flash_message_success);

                        //$("#cart_item").load(" #cart_item > *");
                    }
                }
            })

    });

</script>
@endpush