@extends('layouts.front_template.master')

@section('page')
    Check Out
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
                        <h2>Check-out</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class=""><a href="{{ route('cart') }}">cart / </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Check-out</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!-- section start -->
    <section class="section-b-space">
        <div class="container">
            <div class="checkout-page">
                <div class="checkout-form">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-title">
                                    <h3>Billing Details</h3>
                                </div>
                                <div class="row check-out">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">First Name</div>
                                        <input type="text" name="first_name" id="first_name" value="" placeholder="">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Last Name</div>
                                        <input type="text" name="last_name" id="last_name" value="" placeholder="">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Phone</div>
                                        <input type="text" name="phone" id="phone" value="" placeholder="">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Email Address</div>
                                        <input type="text" name="email" id="email" value="" placeholder="">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Country</div>
                                        <select name="country" id="country">
                                            <option value="">Chose Country</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="SF">South Africa</option>
                                            <option value="USA">United State</option>
                                            <option value="AUS">Australia</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Address</div>
                                        <input type="text" name="address" id="address" value="" placeholder="Street address">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Town/City</div>
                                        <input type="text" name="city" id="city" value="" placeholder="">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                        <div class="field-label">State / County</div>
                                        <input type="text" name="state" id="state" value="" placeholder="">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                        <div class="field-label">Postal Code</div>
                                        <input type="text" name="postal" id="postal" value="" placeholder="">
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <div>Product <span>Total</span></div>
                                        </div>

                                        <ul class="qty">
                                            @forelse($order_details as $od)
                                            <li>{{ $od->product_title }} × {{ $od->product_quantity }} <span>&#2547; {{ $od->product_total }}</span></li>
                                            @empty
                                                <li>No Product Found</li>
                                            @endforelse
                                        </ul>

                                        <ul class="sub-total">
                                            <li>Subtotal <span class="count" id="sub_total" rel="{{ $order_place->grand_total }}">&#2547; {{ $order_place->grand_total }}</span></li>
                                            <input type="hidden" id="order_place_id" value="{{ $order_place->id }}">
                                            <li>Shipping
                                                <div class="shipping">
                                                    <div class="shopping-option">
                                                        <label for="free-shipping">&#2547; 60</label>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="total">
                                            <?php
                                                $shipping_charge = 60;
                                            ?>
                                            <li>Total <span class="count" id="grand_total" rel1="{{ $order_place->grand_total + $shipping_charge }}">&#2547; {{ $order_place->grand_total + $shipping_charge }}</span></li>
                                        </ul>
                                    </div>
                                    <div class="payment-box">
                                        <div class="upper-box">
                                            <div class="payment-options">
                                                <ul>
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" name="payment-group" value="card" id="card" checked="checked">
                                                            <label for="payment-1">Card<span class="small-text">Please send a check to StoreName, Store Street, Store Town, Store State /County, Store Postcode.</span></label>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" name="payment-group" value="cod" id="cod">
                                                            <label for="payment-2">Cash On Delivery<span class="small-text">Please send a check to StoreName, Store Street, Store Town, Store State /County, Store Postcode.</span></label>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="radio-option paypal">
                                                            <input type="radio" name="payment-group" value="paypal" id="paypal">
                                                            <label for="payment-3">PayPal<span class="image"><img src="{{ asset('assets/front_end/assets/images/paypal.png') }}" alt=""></span></label>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="text-end"><a href="#" class="btn-solid btn order_confirm">Place Order</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->
@endsection

@push('js')
<script>
    $(document).on("click", ".order_confirm", function (e) {
        e.preventDefault();

        var order_place_id = $("#order_place_id").val();

        var sub_total = $("#sub_total").attr('rel');

        var grand_total = $("#grand_total").attr('rel1');

        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var country = $("#country").val();
        var address = $("#address").val();
        var city = $("#city").val();
        var state = $("#state").val();
        var postal = $("#postal").val();

        $.ajax({
            url : "{{ route('order') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "post",
            data: {
                order_place_id:order_place_id,
                sub_total:sub_total,
                grand_total:grand_total,
                first_name:first_name,
                last_name:last_name,
                email:email,
                phone:phone,
                country:country,
                address:address,
                city:city,
                state:state,
                postal:postal
            },
            dataType: "json",
            success: function (data) {
                if(data.flash_message_success) {
                    toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        },
                        toastr.success(data.flash_message_success);
                    window.location.href = "{{ route('thank') }}";
                    sessionStorage.removeItem('cart_token');
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