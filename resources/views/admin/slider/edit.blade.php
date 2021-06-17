@extends('layouts.admin_template.master')

@section('page')
    Product Slider Edit
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
                    <form action="" method="post" id="slider_edit">
                        @csrf

                        <input type="hidden" id="slider_id" value="{{ $slider->id }}">

                        <div class="form-group row">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" value="{{ $slider->slider_name }}" name="slider_name" id="slider_name" class="form-control">
                        </div>

                        <div class="form-group row">
                            <label for="name" class="control-label">Image</label>
                            <input type="file" name="slider_image" id="slider_image" class="form-control">
                            <input type="hidden" name="current_image" id="current_image" value="{{ $slider->slider_image }}">
                        </div>

                        @if (!empty($slider->slider_image))
                            <div>
                                <img src="{{ asset('assets/admin/uploads/slider/small/'.$slider->slider_image) }}" alt="">
                            </div>
                        @else
                            <div id="image-holder"></div>
                        @endif

                        <br>

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

        $("#slider_edit").on("submit",function (e) {
            e.preventDefault();

            var slider_id = $("#slider_id").val();

            var formData = new FormData( $("#slider_edit").get(0));

            $.ajax({
                url : "{{ route('slider.update','') }}/"+slider_id,
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