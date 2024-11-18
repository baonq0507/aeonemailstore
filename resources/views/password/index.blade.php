@extends('layouts.app')
@section('title', __('mess.change_password2'))
@push('css')
<style>
    body {
        background-color: rgb(245 245 245/1);
    }
</style>
@endpush
@section('content')
<div class="container mt-3">
    <h5 class="fw-bold">{{ __('mess.change_password2') }}</h5>
    <hr>
    <form action="{{ route('password2.change') }}" method="post" id="form-password2">
        @csrf
        <div class="input-group mb-3">
            <input type="password" name="password2_old" id="password2_old" class="form-control" placeholder="{{ __('mess.password2_old') }}" required>
            <span class="input-group-text">
                <i class="fa-solid fa-lock"></i>
            </span>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password2" id="password2" class="form-control" placeholder="{{ __('mess.password2') }}" required>
            <span class="input-group-text">
                <i class="fa-solid fa-lock"></i>
            </span>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password2_confirm" id="password2_confirm" class="form-control" placeholder="{{ __('mess.password2_confirm') }}" required>
            <span class="input-group-text">
                <i class="fa-solid fa-lock"></i>
            </span>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-secondary w-100">{{ __('mess.confirm') }}</button>
        </div>
    </form>
</div>
@include('includes.footer')
@endsection
@push('script')
<script>
    $(document).ready(function() {
        $('#password2_old').focus();

        $('#form-password2').submit(function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            post("{{ route('password2.change') }}", data).then(response => {
                Swal.fire({
                    icon: 'success',
                    title: "{{ __('mess.login_success') }}",
                    text: response.message
                });
                setTimeout(() => {
                    window.location.href = "{{ route('user.index') }}"
                }, 1500);
            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: "{{ __('mess.login_error') }}",
                    text: error.responseJSON.message
                });
            });
        });
    });
</script>
@endpush
