@extends('layouts.front_template.master')

@section('page')
    Cart
@endsection

@push('css')
@endpush

@section('content')
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
                            <li class=""><a href="{{ route('kites') }}">Home / </a></li>
                            <li class="breadcrumb-item">cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="cart-section section-b-space" id="loadAllCartItme">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="cart_counter">
                        <div class="countdownholder">
                           Here your all products cart list
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 table-responsive-xs">
                    <table class="table cart-table">
                        <thead>
                        <tr class="table-head">
                            <th scope="col">image</th>
                            <th scope="col">product name</th>
                            <th scope="col">price</th>
                            <th scope="col">quantity</th>
                            <th scope="col">action</th>
                            <th scope="col">total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($carts as $key => $cart)
                            <input type="hidden" class="product_id" rel8="{{ $cart->product_id }}">
                        <tr>
                            <td>
                                <a href="#"><img src="{{ asset('assets/admin/uploads/product/small/'.$cart->image) }}" alt=""></a>
                            </td>
                            <td><a href="#" class="product_title" rel4="{{ $cart->product_title }}">{{ $cart->product_title }}</a></td>

                            <td><h2 class="product_price" rel5="{{ $cart->price }}">&#2547; {{ $cart->price }}</h2></td>

                            <td>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <input type="number" name="quantity" id="quantity" rel1="{{  $cart->id }}" rel2="{{ $cart->product_size_id }}" rel3="{{ $cart->product_quantity }}" class="form-control input-number update_quantity" value="{{ $cart->product_quantity }}">
                                    </div>
                                </div>
                            </td>

                            <td><a href="#" class="icon remove_cart" rel="{{ $cart->id }}"><i class="fa fa-close"></i></a></td>

                            <td>
                                <h2 class="td-color product_total" rel9="{{ $cart->price * $cart->product_quantity }}">&#2547; {{ $cart->price * $cart->product_quantity }}</h2>
                                <input type="hidden" class="product_quantity" rel6="{{ $cart->product_quantity }}">
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td>No Item found</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="table-responsive-md">
                        <table class="table cart-table ">
                            <tfoot>
                            <tr>
                                <td>total price :</td>
                                <td>
                                    <h2 class="sub_total" rel7="{{ $sub_total }}">&#2547; {{ $sub_total }}</h2>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-6"><a href="{{ route('kites') }}" class="btn btn-solid">continue shopping</a></div>
                <div class="col-6"><a href="{{ route('check_out') }}" class="btn btn-solid check_out">check out</a></div>
            </div>
        </div>
    </section>
    <!--section end-->
@endsection

@push('js')
<script>
    $(document).on("click", ".remove_cart", function (e) {
        e.preventDefault();

        var cart_id = $(this).attr('rel');

        $.ajax({
            url : "{{ route('cart.remove') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "post",
            data: {cart_id:cart_id},
            dataType: "json",
            success: function (data) {
                if(data.flash_message_success) {
                    toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        },
                        toastr.success(data.flash_message_success);
                    $("#loadAllCartItme").load(" #loadAllCartItme > *");
                }else {

                    toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        },
                        toastr.error(data.error);
                }

                $("form").trigger("reset");
                $('.form-group').find('.valids').hide();
            }
        });
    });

    $(document).on("click",".update_quantity", function (e) {
        e.preventDefault();

        var carts_id = $(this).attr('rel1');

        var product_size_id = $(this).attr('rel2');

        var product_quantity = $(this).val();

        $.ajax({
            url : "{{ route('cart.update') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "post",
            data: {carts_id:carts_id,product_size_id:product_size_id, product_quantity:product_quantity},
            dataType: "json",
            success: function (data) {
                if(data.flash_message_success) {
                    toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        },
                        toastr.success(data.flash_message_success);
                    $("#loadAllCartItme").load(" #loadAllCartItme > *");
                }else {

                    toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        },
                        toastr.error(data.error);
                }

                $("form").trigger("reset");
                $('.form-group').find('.valids').hide();
            }
        });
    })

    $(document).on("click", ".check_out", function (e) {
        e.preventDefault();

        var product_id = $(".product_id").attr('rel8');

        var sub_total = $(".sub_total").attr('rel7');

        //console.log(product_id);

        $.ajax({
            url : "{{ route('order_place') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "post",
            data: {sub_total:sub_total,product_id:product_id},
            dataType: "json",
            success: function (data) {
                if(data.flash_message_success) {
                    toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        },
                        toastr.success(data.flash_message_success);
                    window.location.href = "{{ route('check_out') }}";
                }else {

                    toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        },
                        toastr.error(data.error);
                }

                $("form").trigger("reset");
                $('.form-group').find('.valids').hide();
            }
        });
    })
</script>
@endpush