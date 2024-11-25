@extends('layouts.app')
@push('css')
<style>
    .card-body {
        background-image: linear-gradient(#f8f4f4, #fff);
    }
</style>
@endpush
@section('content')
<div class="container mt-3">
    <img src="{{ asset('images/feedback.png') }}" alt="feedback" class="w-100">

    <div class="card mb-3">
        <div class="card-body px-4">
            <div class="row bg-white p-2 rounded-3 align-items-center">
                <div class="col-2">
                    <img src="{{ asset('images/tb.png') }}" width="30" height="30">
                </div>
                <div class="col-8 text-center">
                    <p class="mb-0 fs-12">{{ __('mess.feedback') }}</p>
                </div>
                <div class="col-2 text-end">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </div>
            <p class="fs-13 text-center mt-3">{{ __('mess.feedback_desc1') }}</p>
            <p class="fs-13 text-center">{{ __('mess.feedback_desc2') }}</p>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
