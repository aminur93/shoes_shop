@extends('layouts.front_template.master')

@section('page')
    Congratulation
    @endsection

@push('css')
@endpush

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>Kites Bangladesh</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class=""><a href="{{ route('kites') }}">Home / </a></li>
                            <li class="breadcrumb-item">Congratulation</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <section class="cart-section section-b-space" id="loadAllCartItme">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="cart_counter">
                        <div class="countdownholder">
                            It has great to shopping at our store
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 table-responsive-xs">
                    <h1>Thank you chose us, stay with us</h1>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-6"><a href="{{ route('kites') }}" class="btn btn-solid">continue shopping</a></div>
            </div>
        </div>
    </section>
@endsection

@push('js')
@endpush