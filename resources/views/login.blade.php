@extends('layouts.front_template.master')

@section('page')
    Customer Login
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
                        <h2>customer's login</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class=""><a href="">Home / </a></li>
                            <li class="breadcrumb-item active">login</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Login</h3>
                    <div class="theme-card">
                        <form class="theme-form" method="post" id="login_post">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" id="email" placeholder="Email" required="">
                            </div>
                            <div class="form-group">
                                <label for="review">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required="">
                            </div>

                            <button type="submit" class="btn btn-solid">Login</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 right-login">
                    <h3>New Customer</h3>
                    <div class="theme-card authentication-right">
                        <h6 class="title-font">Create A Account</h6>
                        <p>Sign up for a free account at our store. Registration is quick and easy. It allows you to be
                            able to order from our shop. To start shopping click register.</p><a href="{{ route('customer.register') }}" class="btn btn-solid">Create an Account</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection

@push('js')
<script>
    $(document).ready(function () {

        $("#login_post").on("submit",function (e) {
            e.preventDefault();

            var email = $("#email").val();

            var password = $("#password").val();

            var session_id = sessionStorage.getItem('cart_token');

            $.ajax({
                url : "{{ route('customer.login_store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                data: {email:email, password:password, session_id:session_id},
                dataType: "json",
                success: function (data) {

                    if(data.flash_message_success) {
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            },
                            toastr.success(data.flash_message_success);

                        window.location.href = "http://localhost:8000/cart";
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
    })
</script>
@endpush