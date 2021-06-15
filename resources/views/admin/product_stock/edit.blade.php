@extends('layouts.admin_template.master')

@section('page')
    Product Stock Edit
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
                    <form action="" method="post" id="product_stock_edit">
                        @csrf

                        <input type="hidden" id="product_stock_id" value="{{ $product_stock->id }}">

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="name" class="control-label">Name</label>
                                <select name="product_id" id="product_id" class="form-control">
                                    <option value="">Select Product</option>
                                    @foreach($product as $p)
                                        <option value="{{ $p->id }}" @if($product_stock->product_id == $p->id) selected @endif>{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="name" class="control-label">Size</label>
                                <select name="size" id="size" class="form-control">
                                    <option value="">Select Product</option>
                                    <option value="small" @if($product_stock->size == "small") selected @endif>Small</option>
                                    <option value="medium" @if($product_stock->size == "medium") selected @endif>Medium</option>
                                    <option value="large" @if($product_stock->size == "large") selected @endif>Large</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="name" class="control-label">Quantity</label>
                                <input type="number" name="quantity" value="{{ $product_stock->quantity }}" id="quantity" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <a href="{{ route('product_stock') }}" class="btn btn-warning">Back</a>
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

        $("#product_stock_edit").on("submit",function (e) {
            e.preventDefault();

            var product_stock_id = $("#product_stock_id").val();

            var formData = new FormData( $("#product_stock_edit").get(0));

            $.ajax({
                url : "{{ route('product_stock.update','') }}/"+product_stock_id,
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