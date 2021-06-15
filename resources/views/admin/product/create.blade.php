@extends('layouts.admin_template.master')

@section('page')
    Create Product
@endsection

@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div id="success_message"></div>

            <div id="error_message"></div>

            <div class="card card-default">
                <div class="card-header">@yield('page')</div>

                <div class="card-body">
                    <form action="" method="post" id="product_post">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="control-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($category as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="">Product Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Product Name">
                        </div>



                        <div class="form-group col-md-12">
                            <label for="Description" class="control-label">Product Description</label>
                            <textarea name="description" id="description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="control-label">Product Price</label>
                            <input type="text" name="price" id="price" class="form-control">
                        </div>

                        <div class="form-group row">
                            <label for="name" class="control-label">Product Quantity</label>
                            <input type="text" name="quantity" id="quantity" class="form-control">
                        </div>


                        <div class="form-group row">
                            <label for="name" class="control-label">Product Image</label>
                            <input type="file" name="image" id="image" class="form-control">

                        </div>

                        <br>
                        <div id="image-holder" class="text-center"></div>

                        <br>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="status">Publish</label>
                                <input type="checkbox" name="publish" id="publish">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="publish">Feature</label>
                                <input type="checkbox" name="feature" id="feature">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="feature">New Arrival</label>
                                <input type="checkbox" name="new_arrival" id="new_arrival">
                            </div>
                        </div>

                        <div class="form-group">
                            <a href="{{ route('products') }}" class="btn btn-warning">Back</a>
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
    $("#image").on('change', function () {

        if (typeof (FileReader) != "undefined") {

            var image_holder = $("#image-holder");
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image",
                    "width": "100px",
                    "height": "100px"
                }).appendTo(image_holder);

            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    });



    $(document).ready(function () {

        $("#product_post").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#product_post").get(0));

            $.ajax({
                url : "{{ route('products.store') }}",
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