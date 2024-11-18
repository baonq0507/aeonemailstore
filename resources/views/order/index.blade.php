@extends('layouts.app')
@section('title', __('mess.order_history'))
@section('content')
<div class="container mt-3">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ $status == 'all' ? 'active text-white' : 'text-dark' }}" href="{{ route('order.index', ['status' => 'all']) }}">{{ __('mess.all') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'pending' ? 'active text-white' : 'text-dark' }}" href="{{ route('order.index', ['status' => 'pending']) }}">{{ __('mess.pending') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'success' ? 'active text-white' : 'text-dark' }}" href="{{ route('order.index', ['status' => 'success']) }}">{{ __('mess.success') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'failed' ? 'active text-white' : 'text-dark' }}" href="{{ route('order.index', ['status' => 'failed']) }}">{{ __('mess.failed') }}</a>
        </li>
    </ul>
    <hr>

    <div class="product">
        <div class="card position-relative">
            <div class="card-body" style="background:linear-gradient(147deg,#71b7ff,#1783fc 74%)">
                <img class="position-absolute end-0" style="width: 100px; top:-10px" src="{{ asset('images/success.png') }}" alt="product" class="img-fluid">
                <p>
                    <img src="{{ asset('images/fpt.png') }}" alt="logo" class="img-fluid" width="30" height="30">
                    <span class="text-white">{{ __('mess.from') }}: AeonMall Group</span>
                </p>
                <p>
                    <span class="text-white">{{ __('mess.product') }}: Keurig K-Duo Coffee Maker,</span>
                </p>
                <p>
                <div class="row">
                    <div class="col-4">
                        <img src="https://m.media-amazon.com/images/I/71zWWzVvSLL._AC_SX679_.jpg" alt="product" width="100" height="100">
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-6">
                                <span class="text-white fs-12">{{ __('mess.order_value') }}</span>
                                <p class="fw-bold" style="color: rgb(13 194 83/1)">+ 100.000đ</p>
                            </div>
                            <div class="col-6">
                                <span class="text-white fs-12">{{ __('mess.profit') }}</span>
                                <p class="fw-bold" style="color: rgb(255 169 0/1)">+ $0.44</p>
                            </div>
                        </div>
                        <p class="fs-12 text-white mb-0">{{ __('mess.order_code') }}: 1234567890</p>
                        <p class="fs-12 text-white mb-0">{{ __('mess.time') }}: 12/12/2024 12:00:00</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
