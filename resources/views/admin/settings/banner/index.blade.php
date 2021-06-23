@extends('layouts.admin_template.master')

@section('page')
    Banner
@endsection

@push('css')
<style type="text/css">
    /* Basic Rules */
    .switch input {
        display:none;
    }
    .switch {
        display:inline-block;
        width:55px;
        height:25px;
        margin:8px;
        transform:translateY(50%);
        position:relative;
    }
    /* Style Wired */
    .slider {
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        right:0;
        border-radius:30px;
        box-shadow:0 0 0 2px #777, 0 0 4px #777;
        cursor:pointer;
        border:4px solid transparent;
        overflow:hidden;
        transition:.4s;
    }
    .slider:before {
        position:absolute;
        content:"";
        width:100%;
        height:100%;
        background:#777;
        border-radius:30px;
        transform:translateX(-30px);
        transition:.4s;
    }

    input:checked + .slider:before {
        transform:translateX(30px);
        background:limeGreen;
    }
    input:checked + .slider {
        box-shadow:0 0 0 2px limeGreen,0 0 2px limeGreen;
    }

    /* Style Flat */
    .switch.flat .slider {
        box-shadow:none;
    }
    .switch.flat .slider:before {
        background:#FFF;
    }
    .switch.flat input:checked + .slider:before {
        background:white;
    }
    .switch.flat input:checked + .slider {
        background:limeGreen;
    }
    .patch{
        margin-top: -25px;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="success_message"></div>

            <div id="error_message"></div>

            <div class="card">
                <div class="card-header">
                    <a href="{{ route('banner.create') }}" class="btn btn-sm btn-primary  float-right"><i class="fas fa-plus"></i> Add Banner</a>
                    <h3 class="card-title">@yield('page')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="data-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#Sl NO</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#Sl NO</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
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

    $(document).ready(function(){

        $('#data-table').DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            pagingType: "full_numbers",
            dom: "<'row'<'col-sm-2'l><'col-sm-4'i><'col-sm-3 text-center'B><'col-sm-3'f>>tp",
            ajax: {
                url: '{!!  route('banner.getData') !!}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'image', name: 'image'},
                {data: 'banner_name', name: 'banner_name'},
                {data: 'status', name: 'status'},
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


    $(document).on('change','.status_toggle', function (e) {
        e.preventDefault();

        //var id = $("#status_change").val();

        var id = $(this).attr('value');

        $.ajax({
            type: "GET",
            url: "{{ route('banner.status_change','') }}/"+id,
            dataType: 'json',
            success: function (data) {

                //$('#data-table').DataTable().ajax.reload();

                if(data.status_code === 200) {
                    $('#success_message').html('<div class="alert alert-secondary  fade show" role="alert">'+
                        '<div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>'+
                        '<div class="alert-text">'+data.message+' !</div>'+
                        '<div class="alert-close">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '<span aria-hidden="true"><i class="la la-close"></i></span>'+
                        '</button>'+
                        '</div>'+
                        '</div>');
                }else {
                    $('#error_message').html('<div class="alert alert-danger fade show" role="alert">'+
                        '<div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>'+
                        '<div class="alert-text">'+data.error+' !</div>'+
                        '<div class="alert-close">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '<span aria-hidden="true"><i class="la la-close"></i></span>'+
                        '</button>'+
                        '</div>'+
                        '</div>');
                }
            }
        });
    })
</script>
@endpush