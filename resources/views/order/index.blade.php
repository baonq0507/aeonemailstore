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
            <a class="nav-link {{ $status == 'completed' ? 'active text-white' : 'text-dark' }}" href="{{ route('order.index', ['status' => 'completed']) }}">{{ __('mess.success') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'failed' ? 'active text-white' : 'text-dark' }}" href="{{ route('order.index', ['status' => 'failed']) }}">{{ __('mess.failed') }}</a>
        </li>
    </ul>
    <hr>

    <div class="product" style="margin-bottom: 100px">
        @foreach ($product as $item)
        <div class="card position-relative mb-3">
            <div class="card-body" style="background:linear-gradient(147deg,#71b7ff,#1783fc 74%)">
                <img class="position-absolute end-0" style="width: 100px; top:-10px" src="{{ asset('images/success.png') }}" alt="product" class="img-fluid">
                <p>
                    <img src="{{ asset('images/fpt.png') }}" alt="logo" class="img-fluid" width="30" height="30">
                    <span class="text-white">{{ __('mess.from') }}: AeonMall Group</span>
                </p>
                <p>
                    <span class="text-white">{{ __('mess.product') }}: {{ \Str::limit($item->product->name, 40) }}</span>
                </p>
                <p>
                <div class="row">
                    <div class="col-4">
                        <img src="{{ $item->product->image }}" alt="product" width="100" height="100" class="img-fluid">
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-6">
                                <span class="text-white fs-12">{{ __('mess.order_value') }}</span>
                                <p class="fw-bold" style="color: rgb(15 231 99)">+ {{ $item->product->price }}</p>
                            </div>
                            <div class="col-6">
                                <span class="text-white fs-12">{{ __('mess.profit') }}</span>
                                <p class="fw-bold" style="color: rgb(255 172 10/1)">+ {{ $item->product->price * $item->product->level->commission / 100 }}</p>
                            </div>
                        </div>
                        <p class="fs-12 text-white mb-0">{{ __('mess.order_code') }}: {{ $item->order_code }}</p>
                        <p class="fs-12 text-white mb-0">{{ __('mess.time') }}: {{ $item->created_at->format('d/m/Y H:i:s') }}</p>
                        <p class="fs-12 text-white mb-0">{{ __('mess.after_balance') }}: {{ $item->after_balance }}</p>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>
@include('includes.footer')
@endsection
