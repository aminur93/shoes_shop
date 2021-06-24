@extends('layouts.admin_template.master')

@section('page')
    Order Invoice
@endsection

@push('css')
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="row">
        <div class="col-md-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"></i> Kites Bangladesh.
                            <small class="float-right">Date: <?php echo date('Y-m-d') ?></small>
                        </h4>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>Kites Bangladesh.</strong><br>
                            113/c/3/a/1 West Shewora para, Suite 600<br>
                            Dhaka Bangladesh,  1216<br>
                            Phone: (+880) 1772119941<br>
                            Email: info@kitesbd.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong>{{ $shipping->first_name.' '.$shipping->last_name }}</strong><br>
                            {{ $shipping->address }}<br>
                            {{ $shipping->country }}, {{ $shipping->city }}<br>
                            Phone: (880) {{ $shipping->phone }}<br>
                            Email: {{ $shipping->email }}
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice <?php $invoice = rand(1000,9999); echo '# '.$invoice;?></b><br>
                        <br>
                        <b>Order ID:</b> {{ $order->id }}<br>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Serial #</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($order_details as $od)
                                <tr>
                                    <td>{{ $od->id }}</td>
                                    <td>{{ $od->product_title }}</td>
                                    <td>{{ $od->product_quantity }}</td>
                                    <td>{{ $od->product_price }}</td>
                                    @foreach($product_size as $key => $ps)

                                        <?php
                                        for ($i=0; $i<count($ps); $i++){
                                        echo $ps[$i]['id'];
                                        if ($od->product_size_id == $ps[$i]['id']){
                                        ?>

                                        <td><?= $ps[$i]['size'] ?></td>

                                        <?php } }?>


                                    @endforeach
                                    <td>&#2547; {{ $od->product_total }}</td>
                                </tr>
                            @empty
                            <tr>
                                <td>No Product Found</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">
                        <p class="lead">Payment Methods: {{ $order_payment->payment_type }}</p>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <p class="lead">Amount Due <?php echo date('Y-m-d') ?></p>

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

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12">
                        <a href="#" onClick="window.print()" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        <a href="{{ route('order') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                </div>
            </div>
            <!-- /.invoice -->
        </div>
    </div>
@endsection

@push('js')
@endpush