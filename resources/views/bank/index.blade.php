@extends('layouts.app')
@section('title', __('mess.bank_info'))
@push('css')
<style>
    body {
        background-color: rgb(248 249 250 / 1);
    }
</style>
@endpush
@section('content')
<div class="container mt-3">
    <h3>{{ __('mess.link_bank_account') }}</h3>
    @if (session('success'))
        <div class="alert alert-success mb-3" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning mb-3" role="alert">
            {{ session('warning') }}
        </div>
    @endif
    <form action="{{ route('bank.store') }}" method="post">
        @csrf
        <div class="form-group mb-3">
            <label for="bank_owner">{{ __('mess.bank_owner') }}</label>
            <input type="text" name="bank_owner" id="bank_owner" class="form-control" placeholder="{{ __('mess.bank_owner') }}" required
            value="{{ old('bank_owner', $user->bank_owner) }}" readonly="{{ $user->bank_owner ? 'readonly' : '' }}">
        </div>
        @error('bank_owner')
            <div class="alert alert-danger mb-3" role="alert">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group mb-3">
            <label for="bank_number">{{ __('mess.bank_number') }}</label>
            <input type="text" name="bank_number" id="bank_number" class="form-control" placeholder="{{ __('mess.bank_number') }}" required
            value="{{ old('bank_number', $user->bank_number) }}" readonly="{{ $user->bank_number ? 'readonly' : '' }}">
        </div>
        @error('bank_number')
            <div class="alert alert-danger mb-3" role="alert">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group mb-3">
            <label for="bank_name">{{ __('mess.bank_name') }}</label>
            <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="{{ __('mess.bank_name') }}" required
            value="{{ old('bank_name', $user->bank_name) }}" readonly="{{ $user->bank_name ? 'readonly' : '' }}">
        </div>
        @error('bank_name')
            <div class="alert alert-danger mb-3" role="alert">
                {{ $message }}
            </div>
        @enderror
        <div class="alert alert-danger mb-3" role="alert">
            {{ __('mess.bank_info_alert') }}
        </div>
        @if (!$user->bank_owner || !$user->bank_number || !$user->bank_name)
            <button type="submit" class="btn btn-secondary w-100">{{ __('mess.save') }}</button>
        @endif
    </form>
</div>
@include('includes.footer')
@endsection
