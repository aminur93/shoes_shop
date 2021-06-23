@extends('layouts.admin_template.master')

@section('page')
    Product Stock
@endsection

@push('css')
@endpush

@section('content')
    <div class="row">

        <div class="col-md-12">

            <div id="success_message"></div>

            <div id="error_message"></div>

            <div class="card">
                <div class="card-body">

                    <form action="" method="post" id="product_stock">
                        @csrf
                        <div id="dataAdd">
                            <div class="container">
                                <div class="form-row">

                                    <div class="form-group col-md-3">
                                        <label for="name" class="control-label">Name</label>
                                        <select name="product_id[]" id="product_id1" class="form-control">
                                            <option value="">Select Product</option>
                                            @foreach($product as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="name" class="control-label">Size</label>
                                        <select name="size[]" id="size1" class="form-control">
                                            <option value="">Select Product</option>
                                            <option value="small">Small</option>
                                            <option value="medium">Medium</option>
                                            <option value="large">Large</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="name" class="control-label">Quantity</label>
                                        <input type="number" name="quantity[]" id="quantity1" class="form-control">
                                    </div>



                                </div>
                            </div>

                            <div class="form-group" style="margin-left: 210px">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group col-md-3" style="margin-top: 35px">
                        <button href="" class="btn btn-sm btn-primary" id="addRow"><i class="fa fa-plus"></i></button>
                        <button href="" class="btn btn-sm btn-danger" id="deleteRow"><i class="fa fa-minus"></i></button>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{--<a href="{{ route('product_stock.create') }}" class="btn btn-sm btn-primary  float-right"><i class="fas fa-plus"></i> Add Product Stock</a>--}}
                    <h3 class="card-title">@yield('page')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="data-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#Sl NO</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#Sl NO</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {

        $("#addRow").click(function(){

            var len=$('#dataAdd .container .form-row').length+1;

            $("#dataAdd .container:last").append(' <div class="form-row">'+
                '<div class="form-group col-md-3">'+
                '<label for="name" class="control-label">Name</label>'+
                '<select name="product_id[]" id="product_id'+len+'" class="form-control">'+
                '<option value="">Select Product</option>'+
                '<?php foreach ($product as $p){ ?>'+
                '<option value="{{ $p->id }}">{{ $p->name }}</option>'+
                '<?php }?>'+
                '</select>'+
                ' </div>'+
                '<div class="form-group col-md-3">'+
                '<label for="name" class="control-label">Size</label>'+
                '<select name="size[]" id="size'+len+'" class="form-control">'+
                '<option value="">Select Product</option>'+
                '<option value="small">Small</option>'+
                '<option value="medium">Medium</option>'+
                '<option value="large">Large</option>'+
                '</select>'+
                '</div>'+
                '<div class="form-group col-md-3">'+
                '<label for="name" class="control-label">Quantity</label>'+
                '<input type="number" name="quantity[]" id="quantity'+len+'" class="form-control">'+
                '</div>'+
                '</div>');

        });
    });

    $("#deleteRow").click(function(){
        var len=$('#dataAdd .container .form-row').length;
        if(len>1){
            $("#dataAdd .container .form-row").last().remove();
        }else{
            alert('Not able to Delete');
        }
    });
</script>

<script>
$(document).ready(function () {
    $("#product_stock").on("submit", function (e) {
        e.preventDefault();

        var formData = new FormData( $("#product_stock").get(0));

        $.ajax({
            url : "{{ route('product_stock.store') }}",
            type: "post",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {

                $('#data-table').DataTable().ajax.reload();

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

<script>

    $(document).ready(function(){

        $('#data-table').DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            pagingType: "full_numbers",
            dom: "<'row'<'col-sm-2'l><'col-sm-4'i><'col-sm-3 text-center'B><'col-sm-3'f>>tp",
            ajax: {
                url: '{!!  route('product_stock.getData') !!}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'size', name: 'size'},
                {data: 'quantity', name: 'quantity'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],

            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-sm btn-info',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                },
                {
                    extend: 'csv',
                    className: 'btn-sm btn-success',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-warning',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-primary',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                },
                {
                    extend: 'print',
                    autoPrint: true,
                    className: 'btn-sm btn-default',
                    exportOptions: {
                        columns: ':visible'
                    },
                    header: false
                }
            ]
        });

    });
</script>

<script>
    $(document).on('click','.deleteRecord', function(e){
        e.preventDefault();
        var id = $(this).attr('rel');
        var deleteFunction = $(this).attr('rel1');
        swal({
                title: "Are You Sure?",
                text: "You will not be able to recover this record again",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Delete It"
            },
            function(){
                $.ajax({
                    type: "delete",
                    url: deleteFunction+'/'+id,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {id:id},
                    success: function (data) {

                        $('#data-table').DataTable().ajax.reload();

                        if(data.flash_message_success) {
                            $('#success_message').html('<div class="alert alert-success">\n' +
                                '<button class="close" data-dismiss="alert">×</button>\n' +
                                '<strong>Success! '+data.flash_message_success+'</strong> ' +
                                '</div>');
                        }
                    }
                });
            });
    });
</script>
@endpush