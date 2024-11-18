@extends('layouts.app')
@section('title', __('mess.upgrade_member'))
@push('css')
<style>
    header {
        background-image: -webkit-linear-gradient(left, #27a6fa, #8e78f5);
        padding: 10px 0;
    }

    .banner {
        background-image: url("{{ asset('images/banner4.png') }}");
        background-size: cover;
        background-position: center;
        padding: 10px 0;
    }
</style>
@endpush
@section('content')
<header>
    <h6 class="fw-bold text-white text-center">{{ __('mess.upgrade_member') }}</h6>
</header>

<div class="banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-2">
                <img src="{{ asset('images/avat.png') }}" alt="" width="50" height="50">
            </div>
            <div class="col-6">
                <h6 class="fs-12 text-white">
                    {{ __('mess.member_info', ['level' => auth()->user()->level->name, 'amount' => auth()->user()->level->order]) }}
                </h6>
            </div>
            <div class="col-4">
                <a href="{{ route('user.index') }}" class="btn btn-sm fs-12 text-white btn-secondary">{{ __('mess.personal_center') }}</a>
            </div>
        </div>
    </div>
</div>
<div class="main container">
    <div class="row mb-3">
        <div class="col-4">
            <img src="{{ asset('images/themhoahong.png') }}" alt="" width="100" height="100">
            <p class="fs-12 text-center">{{ __('mess.add_commission') }}</p>
        </div>
        <div class="col-4">
            <img src="{{ asset('images/themnhiemvu.png') }}" alt="" width="100" height="100">
            <p class="fs-12 text-center">{{ __('mess.add_task') }}</p>
        </div>
        <div class="col-4">
            <img src="{{ asset('images/cskhrieng.png') }}" alt="" width="100" height="100">
            <p class="fs-12 text-center">{{ __('mess.cs_support') }}</p>
        </div>
    </div>

    <div class="row">
        @foreach ($levels as $level)
        <div class="col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-title fs-12 text-center">{{ $level->name }}</p>
                    <p class="card-text fs-12 text-center text-primary mb-0 fw-bold">${{ $level->min_balance }}</p>
                    <p class="card-text fs-12 text-center mb-0">Số nhiệm vụ: {{ $level->order }} đơn/ngày</p>
                    <p class="card-text fs-12 text-center mb-0">Tỉ lệ hoa hồng: {{ $level->commission }}%</p>
                    <p class="card-text fs-12 text-center mb-0">
                        Thời gian hiệu lực của hội viên: {{ $level->valid_days }} ngày
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@include('includes.footer')
@endsection
