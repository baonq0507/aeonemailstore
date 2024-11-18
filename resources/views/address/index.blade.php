@extends('layouts.app')
@section('title', __('mess.address'))
@push('css')
<style>
    body {
        background-color: rgb(248 249 250 / 1);
    }
</style>
@endpush
@section('content')
<div class="container mt-3">
    <h5 class="mb-3">{{ __('mess.address') }}</h5>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('address.store') }}" method="post">
        @csrf
        <div class="form-group mb-3">
            <label for="bank_owner">{{ __('mess.bank_owner') }}</label>
            <input type="text" name="bank_owner" id="bank_owner" class="form-control" placeholder="{{ __('mess.bank_owner') }}" required
                value="{{ old('bank_owner', auth()->user()->bank_owner) }}" readonly>
        </div>
        <div class="form-group mb-3">
            <label for="address">{{ __('mess.address') }}</label>
            <input type="text" name="address" id="address" class="form-control" placeholder="{{ __('mess.address') }}" required
                value="{{ old('address', auth()->user()->address) }}">
        </div>
        @error('address')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @if (auth()->user()->address == null)
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-secondary w-100">{{ __('mess.save') }}</button>
        </div>
        @endif
    </form>
</div>
@include('includes.footer')
@endsection
