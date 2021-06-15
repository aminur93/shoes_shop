@extends('layouts.admin_template.master')

@section('page')
    Product Gallery Image Edit
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
                    <form action="" method="post" id="gallery_image_edit">
                        @csrf

                        <input type="hidden" id="gallery_image_id" value="{{ $product_image->id }}">

                        <div class="form-group row">
                            <label for="name" class="control-label">Image</label>
                            <input type="file" name="gallery_image" id="gallery_image" class="form-control">
                        </div>

                        <br><br>

                        @if (!empty($product_image->gallery_image))
                            <div>
                                <img src="{{ asset('assets/admin/uploads/product_gallery/small/'.$product_image->gallery_image) }}" alt="">
                            </div>
                        @else
                            <div id="image-holder"></div>
                        @endif

                        <br><br>

                        <div class="form-group">
                            <a href="{{ route('product_gallery','') }}/{{ $product_image->id }}" class="btn btn-warning">Back</a>
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

        $("#gallery_image_edit").on("submit",function (e) {
            e.preventDefault();

            var gallery_id = $("#gallery_image_id").val();

            var formData = new FormData( $("#gallery_image_edit").get(0));

            $.ajax({
                url : "{{ route('gallery_image_update','') }}/"+gallery_id,
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