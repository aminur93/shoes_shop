@extends('layouts.admin_template.master')

@section('page')
    Edit Category
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
                    <form action="" method="post" id="edit_post">
                        @csrf

                        <input type="hidden" id="category_id" value="{{ $category->id }}">

                        <div class="form-group row">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" value="{{ $category->category_name }}" name="category_name" id="category_name" class="form-control">
                        </div>

                        <div class="form-group row">
                            <label for="name" class="control-label">Image</label>
                            <input type="file" name="category_image" id="category_image" class="form-control">
                            <input type="hidden" name="current_image" id="current_image" value="{{ $category->category_image }}">
                        </div>

                        @if (!empty($category->category_image))
                            <div>
                                <img src="{{ asset('assets/admin/uploads/category/small/'.$category->category_image) }}" alt="">
                            </div>
                        @else
                            <div id="image-holder"></div>
                        @endif

                        <br>

                        <div class="form-group">
                            <a href="{{ route('category') }}" class="btn btn-warning">Back</a>
                            <button type="submit" class="btn btn-success">Edit</button>
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

        $("#edit_post").on("submit",function (e) {
            e.preventDefault();

            var category_id = $("#category_id").val();

            var formData = new FormData( $("#edit_post").get(0));

            $.ajax({
                url : "{{ route('category.update','') }}/"+category_id,
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