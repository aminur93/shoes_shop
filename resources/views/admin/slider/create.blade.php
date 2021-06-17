@extends('layouts.admin_template.master')

@section('page')
    Product Slider
@endsection

@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div id="success_message"></div>

            <div id="error_message"></div>

            <div class="card card-primary">
                <div class="card-header">@yield('page')</div>

                <div class="card-body">
                    <form action="" method="post" id="slider_post">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" name="slider_name" id="slider_name" class="form-control">
                        </div>

                        <div class="form-group row">
                            <label for="name" class="control-label">Image</label>
                            <input type="file" name="slider_image" id="slider_image" class="form-control">
                        </div>

                        <div class="form-group">
                            <a href="{{ route('slider') }}" class="btn btn-warning">Back</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {

        $("#slider_post").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#slider_post").get(0));

            $.ajax({
                url : "{{ route('slider.store') }}",
                type: "post",
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if(data.flash_message_success) {
                        $('#success_message').html('<div class="alert alert-success">\n' +
                            '<button class="close" data-dismiss="alert">×</button>\n' +
                            '<strong>Success! '+data.flash_message_success+'</strong> ' +
                            '</div>');
                    }else {

                        $('#error_message').html('<div class="alert alert-error">\n' +
                            '<button class="close" data-dismiss="alert">×</button>\n' +
                            '<strong>Error! '+data.error+'</strong>' +
                            '</div>');
                    }

                    $("form").trigger("reset");
                    $('.form-group').find('.valids').hide();
                }
            });
        })
    })
</script>
@endpush