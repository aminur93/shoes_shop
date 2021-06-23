@extends('layouts.front_template.master')

@section('page')
    Customer Register
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
                        <h2>create account</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class=""><a href="{{ route('kites') }}">Home / </a></li>
                            <li class="breadcrumb-item active" aria-current="page">create account</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="register-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>create account</h3>
                    <div class="theme-card">
                        <form class="theme-form" method="post" id="register_post">
                            @csrf
                            <div class="form-row row">
                                <div class="col-md-6">
                                    <label for="email">First Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                                           required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="review">phone</label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" required="">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-6">
                                    <label for="email">email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="review">Password</label>
                                    <input type="password" name="password" class="form-control" id="review" placeholder="Enter your password" required="">
                                </div>

                                <button type="submit" class="btn btn-solid w-auto">create Account</button>
                            </div>
                        </form>
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

        $("#register_post").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#register_post").get(0));

            $.ajax({
                url : "{{ route('register.store') }}",
                type: "post",
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if(data.flash_message_success) {
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            },
                            toastr.success(data.flash_message_success);
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