@extends('layouts.admin_template.master')

@section('page')
    Order Details
@endsection

@push('css')
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">@yield('page')</div>

            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Serial No</th>
                            <th>Product Title</th>
                            <th>Product Price</th>
                            <th>Product Quantity</th>
                            <th>Product Size</th>
                            <th>Product Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($order_details as $od)
                        <tr>
                            <td>{{ $od->id }}</td>
                            <td>{{ $od->product_title }}</td>
                            <td>{{ $od->product_price }}</td>
                            <td>{{ $od->product_quantity }}</td>
                            @foreach($product_size as $key => $ps)

                                <?php
                                    for ($i=0; $i<count($ps); $i++){
                                        echo $ps[$i]['id'];
                                    if ($od->product_size_id == $ps[$i]['id']){
                                ?>

                                <td><?= $ps[$i]['size'] ?></td>

                                <?php } }?>


                            @endforeach
                            <td>{{ $od->product_total }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td>No Product Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <br>
                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">
                        <p class="lead">Payment Methods: {{ $order_payment->payment_type }}</p>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>&#2547; {{ $order->total }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td>&#2547; 60</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>&#2547; {{ $order->grand_total }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush