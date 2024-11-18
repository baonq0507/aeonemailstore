@extends('layouts.app')

@push('css')
<style>
    .wrapper {
        width: 100%;
        height: 100vh;
        background-image: url("{{ asset('images/bg-login.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }

    .center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 400px;
    }

    .form-select {
        width: 150px
    }

    div.lang {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
@endpush
@section('content')
<div class="wrapper">
    <!-- //select lang -->
    <div class="lang">
        <select name="lang" id="lang" class="form-select">
            <option name="ja" value="ja" @if(session('lang')=='ja' ) selected @endif>{{ __('mess.Japanese') }}</option>
            <option name="zh" value="zh" @if(session('lang')=='zh' ) selected @endif>{{ __('mess.Chinese') }}</option>
            <option name="ko" value="ko" @if(session('lang')=='ko' ) selected @endif>{{ __('mess.Korean') }}</option>
            <option name="en" value="en" @if(session('lang')=='en' ) selected @endif>{{ __('mess.English') }}</option>
        </select>
    </div>
    <div class="center">
        <form action="{{ route('login') }}" method="post" id="login-form">
            @csrf
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="{{ __('mess.phone_number') }}" name="phone_number">
                    @error('phone_number')
                    <span class="text-danger ">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" name="password" placeholder="{{ __('mess.password') }}">
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <button id="login" type="submit" class="btn btn-danger w-100">{{ __('mess.login')}}</button>
                <a href="{{ route('register') }}" class="btn btn-secondary w-100 mt-3">{{ __('mess.register')}}</a>
            </div>
        </form>
    </div>
</div>
@include('sweetalert::alert')

@endsection
@push('script')
<script>
    $('#lang').change(function() {
        window.location.href = '/change-lang?lang=' + $(this).val();
    });
    $('#login-form').submit(function(e) {
        e.preventDefault();
        $('#login').prop('disabled', true);
        //loading
        $('#login').html('<i class="fa-solid fa-spinner fa-spin"></i>');
        const formData = $(this).serialize()
        post("{{ route('login') }}", formData).then(response => {
            Swal.fire({
                icon: 'success',
                title: "{{ __('mess.login_success') }}",
                text: response.message
            });
            setTimeout(() => {
                window.location.href = "{{ route('home') }}"
            }, 1500);
        }).catch(error => {
            console.log(error);
            $('#login').prop('disabled', false);
            $('#login').html("{{ __('mess.login')}}");
            Swal.fire({
                icon: 'error',
                title: "{{ __('mess.login_error') }}",
                text: error.responseJSON.message
            });
        });
    });
</script>
@endpush
