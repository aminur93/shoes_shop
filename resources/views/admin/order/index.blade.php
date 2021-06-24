@extends('layouts.admin_template.master')

@section('page')
    Orders
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
                    <h3 class="card-title">@yield('page')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="data-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#Sl NO</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Payment Type</th>
                            <th>Total</th>
                            <th>Grand Total</th>
                            <th>Confirm</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#Sl NO</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Payment Type</th>
                            <th>Total</th>
                            <th>Grand Total</th>
                            <th>Confirm</th>
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
                url: '{!!  route('order.getData') !!}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'payment_type', name: 'payment_type'},
                {data: 'total', name: 'total'},
                {data: 'grand_total', name: 'grand_total'},
                {data: 'confirm', name: 'confirm'},
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
    $(document).on('change','.confirm_toggle', function (e) {
        e.preventDefault();

        //var id = $("#status_change").val();

        var id = $(this).attr('value');

        $.ajax({
            type: "GET",
            url: "{{ route('order.confirm_status','') }}/"+id,
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