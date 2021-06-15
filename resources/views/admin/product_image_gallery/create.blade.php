@extends('layouts.admin_template.master')

@section('page')
    Product Image Gallery
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
                    <form method="post" action="{{ route('gallery_image_store','') }}/{{ $product->id }} " class="dropzone" id="dropzone" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">

                    </form>

                    <br>
                    <div class="form-group">
                        <a href="{{ route('product_gallery','') }}/{{ $product->id }}" class="btn btn-warning">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    Dropzone.options.dropzone =
        {
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            uploadMultiple: true,
            timeout: 5000,
            removedfile: function(file)
            {
                var _token = $('input[name = "_token"]').val();
                var name = file.upload.filename;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('image_delete') }}',
                    data: {filename: name, _token:_token},
                    success: function (data){
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function(file, response)
            {
                console.log(response);
            },
            error: function(file, response)
            {
                return false;
            }
        };
</script>
@endpush